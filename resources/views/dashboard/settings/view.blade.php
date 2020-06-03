@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Settings</div>
                    <div class="card-body">
                        <form action="/admin/settings" method="POST">
                            @csrf
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="mb-0">Email Settings:</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <input type="text" value="<?php echo isset($settings["email"])?$settings["email"]:"" ?>" name="email" placeholder="Email Settings" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="mb-0">CC Email Settings:</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <input type="text" value="<?php echo isset($settings["cc_email"])?$settings["cc_email"]:"" ?>" name="cc_email" placeholder="CC Email Settings" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="mb-0">BCC Email Settings:</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <input type="text" value="<?php echo isset($settings["bcc_email"])?$settings["bcc_email"]:"" ?>" name="bcc_email" placeholder="BCC Email Settings" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-primary">Save Settings</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
