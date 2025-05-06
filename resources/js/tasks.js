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
    $('#tag-form').on('submit', function (e) {
        e.preventDefault();

        const token = localStorage.getItem('api_token');
        const id = $('#tag-id').val(); // если пусто — значит создаём
        const method = id ? 'PATCH' : 'POST';
        const url = id ? `/api/tags/${id}` : '/api/tags';

        $.ajax({
            url: url,
            method: method,
            headers: {
                Authorization: `Bearer ${token}`
            },
            data: {
                title: $('#tag-title').val()
            },
            success: function () {
                $('#tag-title').val('');
                $('#tag-id').val('');
                loadTags();
            },
            error: function (xhr) {
                alert('Ошибка при сохранении тэга:' + (xhr.responseJSON?.message || 'Ошибка'));
            }
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
    const token = localStorage.getItem('api_token');

    $.ajax({
        url: '/api/tags',
        method: 'GET',
        headers: {
            Authorization: `Bearer ${token}`
        },
        success: function (tags) {
            tagsCache = tags;
            $('#tags').html('');
            $('#tag-list').html('');
            tags.forEach(tag => {
                $('#tags').append(`<option value="${tag.id}">${tag.title}</option>`);
                $('#tag-list').append(`
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>${tag.title}</span>
                        <div>
                            <button class="btn btn-sm btn-warning me-2" onclick="editTag(${tag.id}, '${tag.title}')">Изменить</button>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteTag(${tag.id})">Удалить</button>
                        </div>
                    </li>
                `);
            });
        },
        error: function () {
            // alert('Ошибка при загрузке тегов. Пожалуйста, авторизуйтесь снова.');
            // window.location.href = '/login';
        }
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
function editTag(id, title) {
    $('#tag-id').val(id);
    $('#tag-title').val(title);
    $('#tag-title').focus();
}
function deleteTag(id) {
    if (confirm('Удалить тег?')) {
        const token = localStorage.getItem('api_token');

        $.ajax({
            url: `/api/tags/${id}`,
            method: 'DELETE',
            headers: {
                Authorization: `Bearer ${token}`
            },
            success: function () {
                loadTags();
                loadTasks();
            },
            error: function (xhr) {
                alert('Не удалось удалить тэг: ' + (xhr.responseJSON?.message || 'Ошибка'));
            }
        });
    }
}


window.editTask = editTask;
window.deleteTask = deleteTask;
window.editTag = editTag;
window.deleteTag = deleteTag;
