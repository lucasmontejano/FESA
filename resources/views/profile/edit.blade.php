@extends('layouts.app')

@section('title', 'Meus Torneios')

@section('content')
    <!-----Banner----->
    <section class="banner-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Edit Profile</h1>
                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="profile_picture">Profile Picture:</label>
                            <input type="file" name="profile_picture" id="profile_picture" class="form-control">
                            @error('profile_picture')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea name="description" id="description" class="form-control" rows="5">{{ old('description', $user->description) }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection