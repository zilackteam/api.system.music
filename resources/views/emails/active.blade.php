{{-- Email template for reset password link --}}
Click here to active your account: {{ env('APP_CMS_URL', 'http://localhost:3000') . '/user/active/'. $token }}