let tagsCache = [];
function editTask(id) {
    const token = localStorage.getItem('api_token');

    $.ajax({
        url: `/api/tasks/${id}`,
        method: 'GET',
        headers: {
            Authorization: `Bearer ${token}`
        },
        success: function (task) {
            $('#task-id').val(task.id);
            $('#title').val(task.title);
            $('#text').val(task.text);
            $('#tags').val(task.tags.map(tag => tag.id));
            $('#taskModal').modal('show');
        },
        error: function (xhr) {
            alert('Не удалось загрузить задачу: ' + (xhr.responseJSON?.message || 'Ошибка'));
        }
    });
}
$(document).ready(function () {
    loadTasks();
    loadTags();

    // Сохранение задачи
    $('#task-form').on('submit', function (e) {
        e.preventDefault();
        const id = $('#task-id').val();
        const method = id ? 'PATCH' : 'POST';
        const url = id ? `/api/tasks/${id}` : '/api/tasks';

        $.ajax({
            url: url,
            method: method,
            headers: {
                Authorization: `Bearer ${localStorage.getItem('api_token')}`
            },
            data: {
                title: $('#title').val(),
                text: $('#text').val(),
                tags: $('#tags').val(),
            },
            success: function () {
                $('#taskModal').modal('hide');
                $('#task-form')[0].reset();
                $('#task-id').val('');
                loadTasks();
            },
            error: function (xhr) {
                alert('Ошибка при сохранении задачи: ' + (xhr.responseJSON?.message || ''));
            }
        });
    });

    // Создание тега
    $('#tag-form').on('submit', function (e) {
        e.preventDefault();
        $.post('/api/tags', {title: $('#tag-title').val()}, function () {
            $('#tag-title').val('');
            loadTags();
        });
    });
});

function loadTasks() {
    const token = localStorage.getItem('api_token');

    $.ajax({
        url: '/api/tasks',
        method: 'GET',
        headers: {
            Authorization: `Bearer ${token}`
        },
        success: function (tasks) {
            $('#task-list').html('');
            tasks.forEach(task => {
                $('#task-list').append(`
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">${task.title}</h5>
                                <p class="card-text">${task.text || ''}</p>
                                <div>
                                    ${(task.tags || []).map(tag => `<span class="badge bg-info me-1">${tag.title}</span>`).join('')}
                                </div>
                                <hr>
                                <button class="btn btn-sm btn-warning" onclick="editTask(${task.id})">Редактировать</button>
                                <button class="btn btn-sm btn-danger" onclick="deleteTask(${task.id})">Удалить</button>
                            </div>
                        </div>
                    </div>
                `);
            });
        },
        error: function () {
            // alert('Ошибка авторизации. Пожалуйста, войдите снова.');
            // window.location.href = '/login';
        }
    });
}

function loadTags() {
    $.get('/api/tags', function (tags) {
        tagsCache = tags;
        $('#tags').html('');
        $('#tag-list').html('');
        tags.forEach(tag => {
            $('#tags').append(`<option value="${tag.id}">${tag.title}</option>`);
            $('#tag-list').append(`
                <li class="list-group-item d-flex justify-content-between">
                    ${tag.title}
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteTag(${tag.id})">Удалить</button>
                </li>
            `);
        });
    });
}


function deleteTask(id) {
    const token = localStorage.getItem('api_token');

    if (confirm('Удалить задачу?')) {
        $.ajax({
            url: `/api/tasks/${id}`,
            method: 'DELETE',
            headers: {
                Authorization: `Bearer ${token}`
            },
            success: loadTasks,
            error: function (xhr) {
                alert('Не удалось удалить задачу: ' + (xhr.responseJSON?.message || 'Ошибка'));
            }
        });
    }
}

function deleteTag(id) {
    if (confirm('Удалить тег?')) {
        $.ajax({
            url: `/api/tags/${id}`,
            method: 'DELETE',
            success: loadTags
        });
    }
}

window.editTask = editTask;
window.deleteTask = deleteTask;
