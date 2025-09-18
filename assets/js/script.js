// assets/js/script.js

// ==============================================
// FUNÇÕES GERAIS E UTILITÁRIAS
// ==============================================

/**
 * Inicializa todas as funcionalidades JavaScript quando o DOM estiver carregado
 */
document.addEventListener('DOMContentLoaded', function() {
    initModals();
    initPasswordToggles();
    initFormValidations();
    initTooltips();
    initDashboardFilters();
    initTaskInteractions();
    initMobileMenu();
});

/**
 * Função para exibir mensagens de feedback para o usuário
 * @param {string} message - Mensagem a ser exibida
 * @param {string} type - Tipo de mensagem: 'success', 'error', 'warning'
 * @param {number} duration - Duração em milissegundos (0 para permanente)
 */
function showNotification(message, type = 'success', duration = 3000) {
    // Remove notificações existentes
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => notification.remove());
    
    // Cria a nova notificação
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <span class="notification-message">${message}</span>
            <button class="notification-close">&times;</button>
        </div>
    `;
    
    // Estilos para a notificação
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#4CAF50' : type === 'error' ? '#F44336' : '#FF9800'};
        color: white;
        padding: 15px 20px;
        border-radius: 5px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10000;
        max-width: 350px;
        animation: slideIn 0.3s ease-out;
    `;
    
    document.body.appendChild(notification);
    
    // Botão de fechar
    notification.querySelector('.notification-close').addEventListener('click', function() {
        notification.remove();
    });
    
    // Remove automático após a duração especificada
    if (duration > 0) {
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, duration);
    }
}

/**
 * Função para fazer requisições AJAX
 * @param {string} url - URL para a requisição
 * @param {string} method - Método HTTP: 'GET', 'POST', etc.
 * @param {Object} data - Dados a serem enviados
 * @param {Function} callback - Função de callback
 */
function ajaxRequest(url, method, data, callback) {
    const xhr = new XMLHttpRequest();
    const formData = new FormData();
    
    // Adiciona dados ao FormData
    for (const key in data) {
        formData.append(key, data[key]);
    }
    
    xhr.open(method, url, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    callback(null, response);
                } catch (e) {
                    callback(e, null);
                }
            } else {
                callback(new Error(`Request failed with status ${xhr.status}`), null);
            }
        }
    };
    
    xhr.send(formData);
}

// ==============================================
// GERENCIAMENTO DE MODAIS
// ==============================================

/**
 * Inicializa todos os modais da aplicação
 */
function initModals() {
    const modals = document.querySelectorAll('.modal');
    
    modals.forEach(modal => {
        // Botão para abrir o modal
        const openButton = document.querySelector(`[data-target="${modal.id}"]`);
        if (openButton) {
            openButton.addEventListener('click', function(e) {
                e.preventDefault();
                openModal(modal.id);
            });
        }
        
        // Botão para fechar o modal
        const closeButton = modal.querySelector('.close-modal');
        if (closeButton) {
            closeButton.addEventListener('click', function() {
                closeModal(modal.id);
            });
        }
    });
    
    // Fechar modal clicando fora dele
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal')) {
            closeModal(e.target.id);
        }
    });
    
    // Fechar modal com a tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const openModal = document.querySelector('.modal[style*="display: flex"]');
            if (openModal) {
                closeModal(openModal.id);
            }
        }
    });
}

/**
 * Abre um modal
 * @param {string} modalId - ID do modal a ser aberto
 */
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden'; // Previne scroll da página
    }
}

/**
 * Fecha um modal
 * @param {string} modalId - ID do modal a ser fechado
 */
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = ''; // Restaura scroll da página
    }
}

// ==============================================
// TOGGLE DE SENHAS (mostrar/ocultar)
// ==============================================

/**
 * Inicializa os toggles de mostrar/ocultar senha
 */
function initPasswordToggles() {
    const toggleButtons = document.querySelectorAll('.toggle-password');
    
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const passwordInput = document.getElementById(targetId);
            
            if (passwordInput) {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    this.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    passwordInput.type = 'password';
                    this.innerHTML = '<i class="fas fa-eye"></i>';
                }
            }
        });
    });
}

// ==============================================
// VALIDAÇÃO DE FORMULÁRIOS
// ==============================================

/**
 * Inicializa a validação de formulários
 */
function initFormValidations() {
    const forms = document.querySelectorAll('form[data-validate]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
    });
}

/**
 * Valida um formulário
 * @param {HTMLFormElement} form - Formulário a ser validado
 * @returns {boolean} - True se o formulário é válido
 */
function validateForm(form) {
    let isValid = true;
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    
    inputs.forEach(input => {
        // Remove mensagens de erro anteriores
        clearError(input);
        
        // Validação básica de campo vazio
        if (!input.value.trim()) {
            showError(input, 'Este campo é obrigatório.');
            isValid = false;
        }
        
        // Validação de email
        if (input.type === 'email' && input.value.trim()) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(input.value)) {
                showError(input, 'Por favor, insira um email válido.');
                isValid = false;
            }
        }
        
        // Validação de senha
        if (input.type === 'password' && input.value.trim() && input.minLength) {
            if (input.value.length < input.minLength) {
                showError(input, `A senha deve ter pelo menos ${input.minLength} caracteres.`);
                isValid = false;
            }
        }
        
        // Validação de confirmação de senha
        if (input.id.includes('confirm') && input.value.trim()) {
            const passwordField = form.querySelector('input[type="password"]:not([id*="confirm"])');
            if (passwordField && input.value !== passwordField.value) {
                showError(input, 'As senhas não coincidem.');
                isValid = false;
            }
        }
    });
    
    return isValid;
}

/**
 * Exibe mensagem de erro para um campo
 * @param {HTMLElement} input - Campo de entrada
 * @param {string} message - Mensagem de erro
 */
function showError(input, message) {
    // Remove erros anteriores
    clearError(input);
    
    // Adiciona classe de erro
    input.classList.add('error');
    
    // Cria elemento de mensagem de erro
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    errorDiv.style.cssText = 'color: #e74c3c; font-size: 14px; margin-top: 5px;';
    
    // Insere após o campo
    input.parentNode.appendChild(errorDiv);
}

/**
 * Limpa mensagens de erro de um campo
 * @param {HTMLElement} input - Campo de entrada
 */
function clearError(input) {
    input.classList.remove('error');
    
    // Remove mensagens de erro
    const errorMessage = input.parentNode.querySelector('.error-message');
    if (errorMessage) {
        errorMessage.remove();
    }
}

// ==============================================
// DASHBOARD E INTERAÇÕES DE PROJETOS
// ==============================================

/**
 * Inicializa filtros do dashboard
 */
function initDashboardFilters() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            filterProjects(filter);
            
            // Ativa o botão selecionado
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
        });
    });
}

/**
 * Filtra projetos no dashboard
 * @param {string} filter - Tipo de filtro: 'all', 'progress', 'completed'
 */
function filterProjects(filter) {
    const projects = document.querySelectorAll('.project-card');
    
    projects.forEach(project => {
        switch(filter) {
            case 'all':
                project.style.display = 'block';
                break;
            case 'progress':
                if (project.querySelector('.status-in-progress')) {
                    project.style.display = 'block';
                } else {
                    project.style.display = 'none';
                }
                break;
            case 'completed':
                if (project.querySelector('.status-completed')) {
                    project.style.display = 'block';
                } else {
                    project.style.display = 'none';
                }
                break;
        }
    });
}

/**
 * Inicializa interações de tarefas
 */
function initTaskInteractions() {
    // Toggle de conclusão de tarefas
    const taskCheckboxes = document.querySelectorAll('.task-checkbox');
    
    taskCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const taskId = this.getAttribute('data-task-id');
            const isCompleted = this.checked;
            
            toggleTaskCompletion(taskId, isCompleted);
        });
    });
}

/**
 * Alterna estado de conclusão de uma tarefa
 * @param {string} taskId - ID da tarefa
 * @param {boolean} isCompleted - Se a tarefa está concluída
 */
function toggleTaskCompletion(taskId, isCompleted) {
    ajaxRequest('../api/toggle_task.php', 'POST', {
        task_id: taskId,
        completed: isCompleted ? 1 : 0
    }, function(err, response) {
        if (err) {
            showNotification('Erro ao atualizar tarefa.', 'error');
            // Reverte a mudança visual em caso de erro
            const checkbox = document.querySelector(`.task-checkbox[data-task-id="${taskId}"]`);
            if (checkbox) {
                checkbox.checked = !isCompleted;
            }
        } else {
            if (response.success) {
                const taskItem = document.querySelector(`.task-item[data-task-id="${taskId}"]`);
                if (taskItem) {
                    if (isCompleted) {
                        taskItem.classList.add('completed');
                    } else {
                        taskItem.classList.remove('completed');
                    }
                }
                showNotification('Tarefa atualizada com sucesso!');
            } else {
                showNotification(response.message, 'error');
            }
        }
    });
}

// ==============================================
// MENU MOBILE
// ==============================================

/**
 * Inicializa menu mobile
 */
function initMobileMenu() {
    const menuToggle = document.querySelector('.menu-toggle');
    const mainNav = document.querySelector('.main-nav');
    
    if (menuToggle && mainNav) {
        menuToggle.addEventListener('click', function() {
            mainNav.classList.toggle('active');
            this.classList.toggle('active');
        });
    }
}

// ==============================================
// TOOLTIPS
// ==============================================

/**
 * Inicializa tooltips
 */
function initTooltips() {
    const elementsWithTooltip = document.querySelectorAll('[data-tooltip]');
    
    elementsWithTooltip.forEach(element => {
        element.addEventListener('mouseenter', showTooltip);
        element.addEventListener('mouseleave', hideTooltip);
    });
}

/**
 * Exibe tooltip
 * @param {Event} e - Evento de mouse
 */
function showTooltip(e) {
    const tooltipText = this.getAttribute('data-tooltip');
    
    // Cria elemento do tooltip
    const tooltip = document.createElement('div');
    tooltip.className = 'tooltip';
    tooltip.textContent = tooltipText;
    tooltip.style.cssText = `
        position: absolute;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        z-index: 1000;
        white-space: nowrap;
    `;
    
    document.body.appendChild(tooltip);
    
    // Posiciona o tooltip
    const rect = this.getBoundingClientRect();
    tooltip.style.top = (rect.top - tooltip.offsetHeight - 5) + 'px';
    tooltip.style.left = (rect.left + (rect.width - tooltip.offsetWidth) / 2) + 'px';
    
    // Armazena referência para remover depois
    this.tooltip = tooltip;
}

/**
 * Oculta tooltip
 */
function hideTooltip() {
    if (this.tooltip) {
        this.tooltip.remove();
        this.tooltip = null;
    }
}

// ==============================================
// ANIMAÇÕES E EFEITOS VISUAIS
// ==============================================

/**
 * Adiciona efeito de carregamento a um botão
 * @param {HTMLElement} button - Botão que está carregando
 */
function setButtonLoading(button) {
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Carregando...';
    button.disabled = true;
    
    // Retorna função para restaurar o botão
    return function() {
        button.innerHTML = originalText;
        button.disabled = false;
    };
}

/**
 * Animação de digitação (para elementos com data-type-effect)
 */
function initTypeEffect() {
    const elements = document.querySelectorAll('[data-type-effect]');
    
    elements.forEach(element => {
        const text = element.getAttribute('data-type-effect');
        let i = 0;
        
        element.textContent = '';
        
        function typeWriter() {
            if (i < text.length) {
                element.textContent += text.charAt(i);
                i++;
                setTimeout(typeWriter, 100);
            }
        }
        
        typeWriter();
    });
}

// ==============================================
// API DE PROJETOS E TAREFAS
// ==============================================

/**
 * Adiciona uma nova ferramenta ao projeto
 * @param {string} projectId - ID do projeto
 * @param {string} toolId - ID da ferramenta
 */
function addToolToProject(projectId, toolId) {
    const restoreButton = setButtonLoading(document.getElementById('addToolBtn'));
    
    ajaxRequest('../api/add_tool.php', 'POST', {
        project_id: projectId,
        tool_id: toolId
    }, function(err, response) {
        restoreButton();
        
        if (err) {
            showNotification('Erro ao adicionar ferramenta.', 'error');
        } else {
            if (response.success) {
                showNotification('Ferramenta adicionada com sucesso!');
                // Recarrega a página após um breve delay
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showNotification(response.message, 'error');
            }
        }
    });
}

/**
 * Exclui um projeto
 * @param {string} projectId - ID do projeto
 */
function deleteProject(projectId) {
    if (!confirm('Tem certeza que deseja excluir este projeto? Esta ação não pode ser desfeita.')) {
        return;
    }
    
    ajaxRequest('../api/delete_project.php', 'POST', {
        project_id: projectId
    }, function(err, response) {
        if (err) {
            showNotification('Erro ao excluir projeto.', 'error');
        } else {
            if (response.success) {
                showNotification('Projeto excluído com sucesso!');
                // Redireciona para o dashboard após um breve delay
                setTimeout(() => {
                    window.location.href = 'dashboard.php';
                }, 1500);
            } else {
                showNotification(response.message, 'error');
            }
        }
    });
}

// ==============================================
// MANIPULAÇÃO DE DATAS E FORMATAÇÕES
// ==============================================

/**
 * Formata uma data para o formato brasileiro
 * @param {string} dateString - Data em formato ISO ou similar
 * @returns {string} - Data formatada (dd/mm/aaaa)
 */
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('pt-BR');
}

/**
 * Calcula diferença entre datas
 * @param {string} startDate - Data de início
 * @param {string} endDate - Data de fim (opcional, usa data atual se não for fornecida)
 * @returns {string} - Diferença formatada
 */
function getDateDiff(startDate, endDate = null) {
    const start = new Date(startDate);
    const end = endDate ? new Date(endDate) : new Date();
    
    const diffTime = Math.abs(end - start);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    
    if (diffDays === 0) {
        return 'Hoje';
    } else if (diffDays === 1) {
        return '1 dia atrás';
    } else if (diffDays < 30) {
        return `${diffDays} dias atrás`;
    } else {
        const diffMonths = Math.floor(diffDays / 30);
        return `${diffMonths} ${diffMonths === 1 ? 'mês' : 'meses'} atrás`;
    }
}

// ==============================================
// INICIALIZAÇÃO DE COMPONENTES ESPECÍFICOS
// ==============================================

/**
 * Inicializa gráficos de progresso (se a biblioteca Chart.js estiver disponível)
 */
function initProgressCharts() {
    if (typeof Chart === 'undefined') {
        return; // Chart.js não está carregado
    }
    
    const progressCtx = document.getElementById('progressChart');
    if (progressCtx) {
        const progressData = JSON.parse(progressCtx.getAttribute('data-progress'));
        
        new Chart(progressCtx, {
            type: 'doughnut',
            data: {
                labels: ['Concluídas', 'Restantes'],
                datasets: [{
                    data: [progressData.completed, progressData.total - progressData.completed],
                    backgroundColor: ['#4CAF50', '#E0E0E0']
                }]
            },
            options: {
                responsive: true,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }
}

// ==============================================
// EVENT LISTENERS GLOBAIS
// ==============================================

// Prevenir envio de formulários com Enter inadvertidamente
document.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        const target = e.target;
        if (target.tagName === 'INPUT' && !target.type === 'textarea') {
            const form = target.closest('form');
            if (form && form.querySelectorAll('input').length > 1) {
                e.preventDefault();
            }
        }
    }
});

// Melhorar acessibilidade para modais
document.addEventListener('keydown', function(e) {
    if (e.key === 'Tab') {
        const modal = document.querySelector('.modal[style*="display: flex"]');
        if (modal) {
            const focusableElements = modal.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
            if (focusableElements.length) {
                const firstElement = focusableElements[0];
                const lastElement = focusableElements[focusableElements.length - 1];
                
                if (e.shiftKey) {
                    if (document.activeElement === firstElement) {
                        lastElement.focus();
                        e.preventDefault();
                    }
                } else {
                    if (document.activeElement === lastElement) {
                        firstElement.focus();
                        e.preventDefault();
                    }
                }
            }
        }
    }
});