@php
    $isEdit = isset($teamMember);
@endphp

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control"
               value="{{ old('name', $isEdit ? $teamMember->name : '') }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Designation</label>
        <input type="text" name="designation" class="form-control" placeholder="e.g. Founder & CEO"
               value="{{ old('designation', $isEdit ? $teamMember->designation : '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label d-block">Status</label>
        <div class="form-check form-switch pt-2">
            <input type="checkbox" class="form-check-input" name="is_active" id="is_active" value="1"
                   {{ old('is_active', $isEdit ? $teamMember->is_active : true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active (shown on homepage)</label>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Photo</label>
        @if($isEdit && $teamMember->photo_url)
            <div class="mb-2">
                <img src="{{ $teamMember->photo_url }}" style="width:80px;height:80px;object-fit:cover;border-radius:50%;">
            </div>
        @endif
        <input type="file" name="photo" class="form-control" accept="image/*">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Profile Link <span class="text-muted small">(optional)</span></label>
        <input type="text" name="link" class="form-control" placeholder="e.g. team-details.html or https://..."
               value="{{ old('link', $isEdit ? $teamMember->link : '') }}">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label"><i class="icofont-facebook"></i> Facebook URL</label>
        <input type="text" name="facebook_url" class="form-control"
               value="{{ old('facebook_url', $isEdit ? $teamMember->facebook_url : '') }}">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label"><i class="icofont-twitter"></i> Twitter URL</label>
        <input type="text" name="twitter_url" class="form-control"
               value="{{ old('twitter_url', $isEdit ? $teamMember->twitter_url : '') }}">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label"><i class="icofont-skype"></i> Skype URL</label>
        <input type="text" name="skype_url" class="form-control"
               value="{{ old('skype_url', $isEdit ? $teamMember->skype_url : '') }}">
    </div>

</div>


