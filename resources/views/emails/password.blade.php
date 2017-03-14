{{-- Email template for reset password link --}}
Click here to reset your password: {{ env('APP_CMS_URL', 'http://localhost:3000') . '/reset-password/'. $token }}