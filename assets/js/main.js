// Esperar a que el documento esté listo
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar la escena AR
    initAR();
    
    // Agregar event listeners para elementos interactivos
    setupInteractiveElements();
});

// Función para inicializar la experiencia AR
function initAR() {
    // Verificar si el navegador soporta WebGL
    if (!AFRAME.utils.device.checkWebGLSupport()) {
        alert('Tu navegador no soporta WebGL, que es necesario para la realidad aumentada.');
        return;
    }

    // Configurar la escena AR
    const scene = document.querySelector('a-scene');
    if (scene) {
        scene.addEventListener('loaded', function() {
            console.log('Escena AR cargada correctamente');
        });

        // Manejar eventos de marcadores
        scene.addEventListener('markerFound', function(e) {
            console.log('Marcador encontrado:', e.target.id);
            // Aquí puedes agregar lógica adicional cuando se encuentra un marcador
        });

        scene.addEventListener('markerLost', function(e) {
            console.log('Marcador perdido:', e.target.id);
            // Aquí puedes agregar lógica adicional cuando se pierde un marcador
        });
    }
}

// Función para configurar elementos interactivos
function setupInteractiveElements() {
    // Agregar animaciones a las tarjetas de niveles
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Manejar clics en botones de nivel
    const levelButtons = document.querySelectorAll('.btn-primary');
    levelButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Aquí puedes agregar lógica adicional antes de navegar al nivel
            console.log('Navegando al nivel:', this.getAttribute('href'));
        });
    });
}

// Función para cargar modelos 3D
function load3DModel(modelPath, position, rotation, scale) {
    const model = document.createElement('a-entity');
    model.setAttribute('gltf-model', modelPath);
    model.setAttribute('position', position);
    model.setAttribute('rotation', rotation);
    model.setAttribute('scale', scale);
    return model;
}

// Función para mostrar mensajes de progreso
function showProgressMessage(message, type = 'info') {
    const messageDiv = document.createElement('div');
    messageDiv.className = `progress-message ${type}`;
    messageDiv.textContent = message;
    
    const container = document.querySelector('.levels-section');
    container.insertBefore(messageDiv, container.firstChild);
    
    // Remover el mensaje después de 3 segundos
    setTimeout(() => {
        messageDiv.remove();
    }, 3000);
}

// Función para manejar el progreso del usuario
function updateUserProgress(levelId, score) {
    // Aquí puedes implementar la lógica para actualizar el progreso en la base de datos
    console.log(`Actualizando progreso - Nivel: ${levelId}, Puntuación: ${score}`);
}

// Función para verificar la compatibilidad del dispositivo
function checkDeviceCompatibility() {
    const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
    const hasCamera = navigator.mediaDevices && navigator.mediaDevices.getUserMedia;
    
    if (!isMobile) {
        showProgressMessage('Para una mejor experiencia, te recomendamos usar un dispositivo móvil', 'warning');
    }
    
    if (!hasCamera) {
        showProgressMessage('Tu dispositivo no tiene acceso a la cámara, que es necesaria para la realidad aumentada', 'error');
    }
}

// Llamar a la verificación de compatibilidad al cargar
checkDeviceCompatibility(); 