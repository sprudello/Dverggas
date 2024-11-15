function showSection(sectionId) {
    document.querySelectorAll('.content-section').forEach(section => {
        section.classList.remove('active');
    });
    document.getElementById(sectionId).classList.add('active');
    document.querySelectorAll('.sidebar-nav a').forEach(link => {
        link.classList.remove('active');
    });
    document.querySelector(`a[href="#${sectionId}"]`).classList.add('active');
}

let editMode = false;

function makeEditable(element, field) {
    const currentValue = element.textContent;
    const input = document.createElement('input');
    input.type = 'text';
    input.value = currentValue;
    input.className = 'edit-input';
    
    input.addEventListener('blur', function() {
        saveChanges(field, this.value, element);
    });
    
    input.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            this.blur();
        }
    });
    
    element.textContent = '';
    element.appendChild(input);
    input.focus();
}

function saveChanges(field, value, element) {
    const formData = new FormData();
    formData.append('field', field);
    formData.append('value', value);

    fetch('update_profile.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            element.textContent = value;
        } else {
            alert(data.message || 'Update failed');
            element.textContent = element.getAttribute('data-original');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        element.textContent = element.getAttribute('data-original');
    });
}

// Add event listeners when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Edit button handler
    document.querySelector('.edit-button').addEventListener('click', function() {
        editMode = !editMode;
        const editIcons = document.querySelectorAll('.edit-icon');
        const detailContents = document.querySelectorAll('.detail-content p');
        
        editIcons.forEach(icon => {
            icon.style.display = editMode ? 'inline-block' : 'none';
        });
        
        detailContents.forEach(content => {
            content.setAttribute('data-original', content.textContent);
        });
        
        // Update edit button
        this.innerHTML = editMode ? 
            '<i class="fa-solid fa-xmark"></i> Cancel' : 
            '<i class="fa-solid fa-pen"></i> Edit';
        this.style.backgroundColor = editMode ? '#dc3545' : '#6600cc';
        
        // Show/hide done button
        const doneButton = document.getElementById('done-button');
        if (doneButton) {
            doneButton.style.display = editMode ? 'inline-block' : 'none';
        }
    });

    // Done button handler
    document.getElementById('done-button').addEventListener('click', function() {
        const editMode = false;
        const editIcons = document.querySelectorAll('.edit-icon');
        const editButton = document.querySelector('.edit-button');
        
        // Hide edit icons
        editIcons.forEach(icon => {
            icon.style.display = 'none';
        });
        
        // Reset edit button
        editButton.innerHTML = '<i class="fa-solid fa-pen"></i> Edit';
        editButton.style.backgroundColor = '#6600cc';
        
        // Hide done button
        this.style.display = 'none';
        
        // Save any remaining editable fields
        document.querySelectorAll('.edit-input').forEach(input => {
            const detailGroup = input.closest('.detail-group');
            const field = detailGroup.getAttribute('data-field');
            saveChanges(field, input.value, input.parentElement);
        });
    });

    // Edit icons handler
    document.querySelectorAll('.edit-icon').forEach(icon => {
        icon.addEventListener('click', function() {
            if (!editMode) return;
            
            const detailGroup = this.closest('.detail-group');
            const contentP = detailGroup.querySelector('p');
            const field = detailGroup.getAttribute('data-field');
            
            makeEditable(contentP, field);
        });
    });
});

function showPasswordModal() {
    document.getElementById('password-modal').style.display = 'block';
}

function closePasswordModal() {
    document.getElementById('password-modal').style.display = 'none';
}

// Close modal when clicking outside of it
window.onclick = function(event) {
    const modal = document.getElementById('password-modal');
    if (event.target == modal) {
        closePasswordModal();
    }
}

// Handle password form submission
document.getElementById('password-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    
    if (formData.get('new_password') !== formData.get('confirm_password')) {
        alert('New passwords do not match!');
        return;
    }

    fetch('update_password.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Password updated successfully!');
            closePasswordModal();
            this.reset();
        } else {
            alert(data.message || 'Failed to update password');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating password');
    });
});
