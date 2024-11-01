document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        const target = document.querySelector(this.getAttribute('href'));
        target.scrollIntoView({
            behavior: 'smooth'
        });
    });
});

window.addEventListener('scroll', function () {
    const sections = document.querySelectorAll('section');
    const triggerPoint = window.innerHeight / 1.3;

    sections.forEach(section => {
        const sectionTop = section.getBoundingClientRect().top;

        if (sectionTop < triggerPoint) {
            section.classList.add('show');
        }
    });
});

document.getElementById('createTopicForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const title = document.getElementById('topicTitle').value;
    const content = document.getElementById('topicContent').value;

    fetch('create_topic.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ title: title, content: content })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Si el tema fue creado, agregarlo a la lista de temas
            const topicsList = document.getElementById('topics');
            const newTopic = document.createElement('li');
            newTopic.textContent = title;
            topicsList.appendChild(newTopic);
        } else {
            alert('Error al crear el tema');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
