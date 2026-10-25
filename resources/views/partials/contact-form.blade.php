{{-- Vars: $source (string, which page), $subject (optional preset), $services (optional collection for subject list), $compact (bool) --}}
<form action="{{ route('contacts.store') }}#contact-form" method="post" class="form {{ !empty($compact) ? 'form--compact' : '' }}" id="contact-form" novalidate data-form>
    @csrf
    <input type="hidden" name="source" value="{{ $source ?? 'Contacts' }}">
    <div class="hp" aria-hidden="true">
        <label>Leave this field empty <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
    </div>

    @if(session('contact_success'))
        <div class="alert alert--success" role="status">
            <x-icon name="check-circle" :size="22" />
            <div><strong>Thank you, your message has been sent.</strong><br>Someone from our team will get back to you shortly.</div>
        </div>
    @endif

    @if($errors->any() && old('source') === ($source ?? 'Contacts'))
        <div class="alert alert--error" role="alert">Please check the highlighted fields and try again.</div>
    @endif

    <div class="form__grid">
        <div class="field">
            <label for="cf-name">Full name <span aria-hidden="true">*</span></label>
            <input id="cf-name" name="name" type="text" value="{{ old('name') }}" required autocomplete="name" @error('name') aria-invalid="true" @enderror>
            @error('name')<p class="field__error">{{ $message }}</p>@enderror
        </div>
        <div class="field">
            <label for="cf-email">Email address <span aria-hidden="true">*</span></label>
            <input id="cf-email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" @error('email') aria-invalid="true" @enderror>
            @error('email')<p class="field__error">{{ $message }}</p>@enderror
        </div>
        @if(empty($compact))
            <div class="field">
                <label for="cf-phone">Phone number</label>
                <input id="cf-phone" name="phone" type="tel" value="{{ old('phone') }}" autocomplete="tel">
            </div>
            <div class="field">
                <label for="cf-org">Organisation</label>
                <input id="cf-org" name="organisation" type="text" value="{{ old('organisation') }}" autocomplete="organization">
            </div>
        @endif
        <div class="field field--full">
            <label for="cf-subject">What can we help with?</label>
            @if(!empty($services) && count($services))
                <select id="cf-subject" name="subject">
                    <option value="">General enquiry</option>
                    @foreach($services as $s)
                        <option value="{{ $s->title }}" @selected(old('subject', $subject ?? '') === $s->title)>{{ $s->title }}</option>
                    @endforeach
                    <option value="Partnership" @selected(old('subject') === 'Partnership')>Partnership</option>
                </select>
            @else
                <input id="cf-subject" name="subject" type="text" value="{{ old('subject', $subject ?? '') }}">
            @endif
        </div>
        <div class="field field--full">
            <label for="cf-message">Your message <span aria-hidden="true">*</span></label>
            <textarea id="cf-message" name="message" rows="{{ !empty($compact) ? 4 : 6 }}" required @error('message') aria-invalid="true" @enderror>{{ old('message') }}</textarea>
            @error('message')<p class="field__error">{{ $message }}</p>@enderror
        </div>
        <div class="field field--full field--check">
            <label class="check">
                <input type="checkbox" name="consent" value="1" @checked(old('consent')) required>
                <span>I agree that Onyx may store the details I submit so they can respond to my enquiry.</span>
            </label>
            @error('consent')<p class="field__error">{{ $message }}</p>@enderror
        </div>
    </div>
    <button type="submit" class="btn btn--primary btn--lg">
        Send message <x-icon name="send" :size="17" />
    </button>
</form>
