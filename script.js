document.addEventListener('DOMContentLoaded', function() {
    // Máscara para o telefone
    const phoneInput = document.getElementById('telefone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length > 0) {
                value = value.replace(/^(\d{2})(\d)/g, '($1) $2');
                
                if (value.length > 9) {
                    value = value.replace(/(\d{5})(\d)/, '$1-$2');
                } else if (value.length > 8) {
                    value = value.replace(/(\d{4})(\d)/, '$1-$2');
                }
            }
            
            e.target.value = value;
        });
    }
    
    // Phone number mask
    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        if (value.length > 0) {
            value = value.replace(/^(\d{2})(\d)/g, '($1) $2');
            
            if (value.length > 9) {
                value = value.replace(/(\d{5})(\d)/, '$1-$2');
            } else if (value.length > 8) {
                value = value.replace(/(\d{4})(\d)/, '$1-$2');
            }
        }
        
        e.target.value = value;
    });
    
    // Show success/error messages
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    const error = urlParams.get('error');
    
    if (status === 'success') {
        const message = document.createElement('div');
        message.className = 'success-message';
        message.textContent = 'Cadastro realizado com sucesso!';
        form.parentNode.insertBefore(message, form);
        
        // Clear form after successful submission
        form.reset();
    }
    
    if (error === 'nodata') {
        const message = document.createElement('div');
        message.className = 'error-message';
        message.textContent = 'Nenhum dado encontrado para gerar o relatório.';
        form.parentNode.insertBefore(message, form);
    }
    
    // Form validation
    form.addEventListener('submit', function(e) {
        let isValid = true;
        const requiredFields = form.querySelectorAll('[required]');
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.style.borderColor = 'red';
            } else {
                field.style.borderColor = '#ddd';
            }
        });
        
        // Validate phone number (at least 10 digits)
        const phoneDigits = phoneInput.value.replace(/\D/g, '');
        if (phoneDigits.length < 10) {
            isValid = false;
            phoneInput.style.borderColor = 'red';
            alert('Por favor, insira um número de telefone válido (com DDD).');
        }
        
        if (!isValid) {
            e.preventDefault();
            alert('Por favor, preencha todos os campos obrigatórios.');
        }
    });
});
