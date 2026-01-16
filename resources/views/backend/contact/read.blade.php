@extends('backend.layouts.app')
@section('title', 'Read Message - '.config('settings.site_name'))
@section('breadcrumb')
<div class="nb">
    <div class="nb-header">
        <div class="nb-header-back">
            <a href="{{ route('backend.contact.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Read Message</h1>
        <div class="nb-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('backend.contact.index') }}">Contact</a></div>
            <div class="breadcrumb-item">Read Message</div>
        </div>
    </div>
</div>
@endsection
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card card-primary" id="contact-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="title">Name</label>
                                    <input type="text" readonly class="form-control-plaintext border-bottom" id="name"
                                        name="title" value="{{  $contact->name }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="email">Email</label>
                                    <input type="text" readonly class="form-control-plaintext border-bottom" id="email"
                                        name="email" value="{{  $contact->email }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="subject">Subject</label>
                                    <input type="text" readonly class="form-control-plaintext border-bottom"
                                        id="subject" name="subject" value="{{  $contact->subject }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="message">Message</label>
                                    <textarea type="text" readonly class="form-control-plaintext border-bottom"
                                        id="message" name="message">{{  $contact->message }}
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection