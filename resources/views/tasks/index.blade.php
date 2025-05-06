@extends('layouts.main')
@section('content')
    <div class="container py-5">
        <h2 class="mb-4">Ваши задачи</h2>
        <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#taskModal">Добавить задачу</button>
        <div id="task-list" class="row g-3"></div>

        <hr class="my-5">
        <h4>Управление тегами</h4>
        <form id="tag-form">
            <input type="hidden" id="tag-id">

            <div class="mb-3">
                <label for="tag-title" class="form-label">Название тега</label>
                <input type="text" id="tag-title" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success mb-3">Сохранить</button>
        </form>
        <ul id="tag-list" class="list-group"></ul>
    </div>
    <div class="modal fade" id="taskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="task-form">
                    <div class="modal-header">
                        <h5 class="modal-title">Задача</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="task-id">
                        <div class="mb-3">
                            <label for="title" class="form-label">Название</label>
                            <input type="text" id="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label">Описание</label>
                            <textarea id="text" class="form-control" rows="3" maxlength="200"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="tags" class="form-label">Теги</label>
                            <select id="tags" class="form-select" multiple></select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

