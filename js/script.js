$(document).ready(function() {
    // Variables de estado
    let currentRole = 'student'; // 'student' o 'teacher'
    
    // Elementos del DOM
    const roleSwitch = $('#role-switch');
    const currentRoleLabel = $('#current-role');
    const studentView = $('#student-view');
    const teacherView = $('#teacher-view');
    const studentMenu = $('#student-menu');
    const teacherMenu = $('#teacher-menu');
    const addEventBtn = $('#add-event-btn');
    const addEventModal = new bootstrap.Modal('#addEventModal');
    const eventDetailsModal = new bootstrap.Modal('#eventDetailsModal');
    const eventForm = $('#event-form');
    
    // Event Listeners
    roleSwitch.change(toggleRole);
    addEventBtn.click(() => addEventModal.show());
    $('#save-event-btn').click(saveEvent);
    $('#event-modality').change(toggleLocationField);
    $('.btn-outline-primary').click(showEventDetails);
    $('#register-event-btn').click(registerForEvent);
    
    // Inicialización
    updateUIForRole();
    
    // Funciones
    function toggleRole() {
        currentRole = roleSwitch.is(':checked') ? 'teacher' : 'student';
        updateUIForRole();
    }
    
    function updateUIForRole() {
        if (currentRole === 'teacher') {
            currentRoleLabel.text('Modo Profesor');
            studentView.hide();
            teacherView.show();
            studentMenu.hide();
            teacherMenu.show();
            $('#username').text('Prof. Martínez');
        } else {
            currentRoleLabel.text('Modo Estudiante');
            studentView.show();
            teacherView.hide();
            studentMenu.show();
            teacherMenu.hide();
            $('#username').text('Est. García');
        }
    }
    
    function toggleLocationField() {
        const modality = $('#event-modality').val();
        const locationField = $('#location-field');
        
        if (modality === 'Presencial') {
            locationField.find('label').text('Lugar');
            $('#event-location').attr('placeholder', 'Ej: Aula 201, Edificio Principal');
        } else if (modality === 'Virtual') {
            locationField.find('label').text('Enlace');
            $('#event-location').attr('placeholder', 'Ej: https://meet.google.com/abc-xyz-123');
        } else {
            locationField.find('label').text('Lugar / Enlace');
            $('#event-location').attr('placeholder', 'Especifique lugar físico y enlace virtual');
        }
    }
    
    function saveEvent() {
        if (eventForm[0].checkValidity()) {
            // Aquí iría la lógica para guardar el evento
            alert('Evento guardado exitosamente');
            addEventModal.hide();
            eventForm[0].reset();
        } else {
            eventForm[0].reportValidity();
        }
    }
    
    function showEventDetails() {
        // Datos de ejemplo para el modal de detalles
        const eventCard = $(this).closest('.card');
        const eventTitle = eventCard.find('.card-title').text();
        const eventDate = eventCard.find('.text-muted').text().replace('<i class="fas fa-calendar-day me-2"></i>', '');
        const eventDescription = eventCard.find('.card-text').not('.text-muted').text();
        const eventType = eventTitle.includes('Taller') ? 'Taller' : 
                         eventTitle.includes('Conferencia') ? 'Conferencia' : 'Seminario';
        const eventModality = eventCard.find('.badge').text();
        
        // Llenar el modal con los datos
        $('#event-detail-title').text(eventTitle);
        $('#event-detail-date').text(eventDate.split(',')[0]);
        $('#event-detail-time').text(eventDate.split(',')[1]);
        $('#event-detail-type').text(eventType);
        $('#event-detail-modality').text(eventModality);
        $('#event-detail-location').text(eventModality === 'Presencial' ? 'Aula 301, Edificio Norte' : 'https://meet.google.com/abc-xyz-123');
        $('#event-detail-description').text(eventDescription);
        $('#event-detail-image').attr('src', eventCard.find('img').attr('src'));
        
        // Mostrar u ocultar botón de registro según el rol
        if (currentRole === 'student') {
            $('#register-event-btn').show();
        } else {
            $('#register-event-btn').hide();
        }
        
        eventDetailsModal.show();
    }
    
    function registerForEvent() {
        alert('Te has registrado exitosamente para este evento');
        eventDetailsModal.hide();
    }
    
    // Simular datos para la vista de profesor
    if (currentRole === 'teacher') {
        // Aquí iría la lógica para cargar los eventos del profesor
    }
});