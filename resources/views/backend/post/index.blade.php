@extends('backend.layouts.app')
@section('title', 'Post - ' . config('settings.site_name'))
@section('breadcrumb')
<div class="nb">
    <div class="nb-header">
        <h1>Post</h1>
        <div class="nb-header-button">
            <a href="{{ route('backend.post.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i>
                Add New
            </a>
        </div>
        <div class="nb-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Post</a></div>
        </div>
    </div>
</div>
@endsection
@section('content')
<section class="section">
    @if (session()->has('flash_notification'))
    <div class="alert alert-{{ session()->get('flash_notification.level') }} alert-has-icon" id="alert">
        <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
        <div class="alert-body">
            <button class="close" data-dismiss="#alert">
                <span>&times;</span>
            </button>
            <div class="alert-title">Info</div>
            {{ session()->get('flash_notification.message') }}
        </div>
    </div>
    @endif
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card mb-0">
                    <div class="card-body">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link {{ route('backend.post.index') == url()->full() ? 'active' : '' }} "
                                    href="{{ route('backend.post.index') }}">
                                    All
                                    <span class="badge badge-white" id="statusAll">
                                        {{ $statusList->get('all') }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('p') == 'own' ? 'active' : '' }}" href="?p=own">
                                    Own
                                    <span class="badge badge-primary" id="statusOwn">
                                        {{ $statusList->get('own') }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('p') == 'published' ? 'active' : '' }}"
                                    href="?p=published">
                                    Published
                                    <span class="badge badge-primary" id="statusPublished">
                                        {{ $statusList->get('published') }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('p') == 'draft' ? 'active' : '' }}" href="?p=draft">
                                    Draft
                                    <span class="badge badge-primary" id="statusDraft">
                                        {{ $statusList->get('draft') }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('p') == 'scheduled' ? 'active' : '' }}"
                                    href="?p=scheduled">
                                    Schedule
                                    <span class="badge badge-primary" id="statusScheduled">
                                        {{ $statusList->get('scheduled') }}
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('p') == 'trash' ? 'active' : '' }}" href="?p=trash">
                                    Trash
                                    <span class="badge badge-primary" id="statusTrash">{{ $statusList->get('trash') }}
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card" id="card-post">
                    <div class="card-header sticky-top bg-white">
                        @if (request('p') == 'trash')
                        <button href="#" class="btn mx-1 btn-danger" id="forceDeleteAll" data-toggle="tooltip"
                            title="Delete All Permanently">
                            <i class=" fas fa-trash"></i> Delete All Permanently
                        </button>
                        <button href="#" class="btn mx-1 btn-warning" id="restoreAll" data-toggle="tooltip"
                            title="Restore All">
                            <i class="fas fa-trash-restore"></i> Restore All
                        </button>
                        @else
                        <button href="#" class="btn btn-danger" id="deleteAll">
                            <i class="fas fa-trash"></i> Delete All
                        </button>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped dt-responsive nowrap" style="width:100%" id="myTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Categories</th>
                                        <th>Created At & Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
@include('backend.post._script')
@endsection