let editMode = false;


function editField(fieldName) {
    const detailGroup = event.target.closest('.detail-group');
    const paragraph = detailGroup.querySelector('p');
    const currentValue = paragraph.textContent;
    
    // Create input field
    const input = document.createElement('input');
    input.type = 'text';
    input.value = currentValue;
    input.className = 'edit-input';
    
    // Create edit button
    const editButton = document.createElement('button');
    editButton.innerHTML = '<i class="fa-solid fa-pen-to-square"></i>';
    editButton.className = 'field-edit-button';
    editButton.onclick = () => editField(fieldName);
    
    // Create cancel button
    const cancelButton = document.createElement('button');
    cancelButton.innerHTML = '<i class="fa-solid fa-xmark"></i>';
    cancelButton.className = 'cancel-button';
    cancelButton.onclick = () => cancelEdit(paragraph, currentValue);
    
    // Replace content
    const editContent = document.createElement('div');
    editContent.className = 'edit-content';
    editContent.appendChild(input);
    editContent.appendChild(saveButton);
    editContent.appendChild(cancelButton);
    
    paragraph.replaceWith(editContent);
}

function saveField(fieldName, value) {
    // Send AJAX request to update the field
    fetch('update_profile.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            field: fieldName,
            value: value
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Failed to update field: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the field');
    });
}

function cancelEdit(paragraph, originalValue) {
    const editContent = event.target.closest('.edit-content');
    paragraph.textContent = originalValue;
    editContent.replaceWith(paragraph);
}

// Initialize theme switch
document.addEventListener('DOMContentLoaded', function() {
    const themeSwitch = document.getElementById('theme-switch');
    if (themeSwitch) {
        const savedDarkMode = localStorage.getItem('darkMode');
        themeSwitch.checked = savedDarkMode === 'true';
        
        themeSwitch.addEventListener('change', function() {
            localStorage.setItem('darkMode', this.checked);
            setTheme(this.checked);
        });
    }
});
