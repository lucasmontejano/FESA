@extends('layouts.app')

@section('title', 'Meus Torneios')

@section('content')
    <!-- -----Banner----- -->
    <section class="pageheader-section" style="background-image: url(images/pageheader/bg.jpg);">
        <section class="banner">
            <div class="container">
                <h2>Create New Team</h2>
                <form action="{{ route('teams.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Team Name (max 32 characters)</label>
                        <input type="text" class="form-control" id="name" name="name" 
                            maxlength="32" required
                            oninput="this.value = this.value.slice(0, 32)">
                    </div>

                    <div class="mb-3">
                        <label for="picture" class="form-label">Team Picture (Optional - JPG/PNG, max 2MB)</label>
                        <input type="file" class="form-control" id="picture" name="picture"
                            accept="image/jpeg, image/png, image/jpg"
                            onchange="validateImage(this)">
                    </div>
                    <button type="submit" class="btn btn-primary">Create Team</button>
                </form>
            </div>
        </section>
    </section>

    <script>
        function validateImage(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                const maxSize = 2 * 1024 * 1024; // 2MB in bytes
                
                if (!validTypes.includes(file.type)) {
                    alert('Please upload a JPG or PNG image only.');
                    input.value = '';
                    return false;
                }
                
                if (file.size > maxSize) {
                    alert('Image size must be less than 2MB.');
                    input.value = '';
                    return false;
                }
            }
            return true;
        }
    </script>
    <!-- -----Banner----- -->
@endsection