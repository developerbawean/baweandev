<script>
    // Function to handle permission changes
    document.querySelectorAll('.form-check-input').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const permissionId = this.id;
            const isChecked = this.checked;
            
            // In a real application, you would send this to your backend
            console.log(`Permission ${permissionId} changed to ${isChecked}`);
            
            // You could add visual feedback here
            if (isChecked) {
                this.parentElement.parentElement.style.backgroundColor = 'rgba(78, 115, 223, 0.05)';
            } else {
                this.parentElement.parentElement.style.backgroundColor = '';
            }
        });
    });
    
    // Function to handle role selection (for demonstration)
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function() {
            document.querySelectorAll('.nav-link').forEach(navLink => {
                navLink.classList.remove('active');
            });
            this.classList.add('active');
        });
    });