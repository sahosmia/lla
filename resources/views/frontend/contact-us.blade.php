@extends('layouts.frontend-app')

@section('content')
<div class="am-contact-wrapper py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 text-center mb-5">
                <div class="am-section-head">
                    <h2 class="am-title">Get in Touch</h2>
                    <p class="am-desc">For training inquiries, corporate programs, or university collaboration, please contact us.</p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="am-contact-sidebar">
                    <div class="am-contact-item mb-4 p-4 border rounded">
                        <h4 class="am-subtitle mb-4">Contact Details</h4>
                        
                        <ul class="am-contact-list list-unstyled">
                            <li class="d-flex mb-3">
                                <span class="am-icon-box me-3"><i class="icon-phone"></i></span>
                                <div>
                                    <span class="d-block text-muted small">Phone / WhatsApp</span>
                                    <a href="tel:+8801742719724" class="am-link">+880 1742 719724</a>
                                </div>
                            </li>
                            <li class="d-flex mb-3">
                                <span class="am-icon-box me-3"><i class="icon-mail"></i></span>
                                <div>
                                    <span class="d-block text-muted small">Email Address</span>
                                    <a href="mailto:info@thelearninglineacademy.com" class="am-link">info@thelearninglineacademy.com</a> 
                                </div>
                            </li>
                            <li class="d-flex mb-3">
                                <span class="am-icon-box me-3"><i class="icon-map-pin"></i></span>
                                <div>
                                    <span class="d-block text-muted small">Training Mode</span>
                                    <p class="mb-0">Online & Physical Training</p> 
                                </div>
                            </li>
                        </ul>

                        <div class="am-social-wrap mt-4 pt-4 border-top">
                            <h5 class="small text-uppercase mb-3">Follow Our Hub</h5>
                            <div class="am-social-links d-flex gap-3">
                                <a href="https://www.youtube.com/@TheLearningLineAcademy" target="_blank" class="am-social-btn youtube"><i class="icon-youtube"></i></a> [cite: 71]
                                <a href="https://www.linkedin.com/in/rafiqul-islam" target="_blank" class="am-social-btn linkedin"><i class="icon-linkedin"></i></a> [cite: 72]
                                <a href="https://www.facebook.com/TheLearningLineAcademy" target="_blank" class="am-social-btn facebook"><i class="icon-facebook"></i></a> [cite: 73]
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="am-form-card p-4 p-md-5 border rounded shadow-sm bg-white">
                    <h4 class="am-subtitle mb-4">Send an Inquiry</h4>
                    <form action="{{ route('contact.inquiry') }}" method="POST" class="am-custom-form">
                    @csrf
                
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="am-label">Full Name *</label>
                                <input type="text" name="name" class="form-control am-input @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" placeholder="Enter your name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="am-label">Email Address *</label>
                                <input type="email" name="email" class="form-control am-input @error('email') is-invalid @enderror" 
                                       value="{{ old('email') }}" placeholder="Enter your email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="am-label">Contact Number *</label>
                                <input type="text" name="phone" class="form-control am-input @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone') }}" placeholder="Enter phone number" >
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="am-label">Organization / University</label>
                                <input type="text" name="organization" class="form-control am-input @error('organization') is-invalid @enderror" 
                                       value="{{ old('organization') }}" placeholder="Enter institution name">
                                @error('organization')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="am-label">Designation</label>
                                <input type="text" name="designation" class="form-control am-input @error('designation') is-invalid @enderror" 
                                       value="{{ old('designation') }}" placeholder="Enter your role">
                                @error('designation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="am-label">Type of Inquiry</label>
                                <select name="inquiry_type" class="form-select am-input shadow-none @error('inquiry_type') is-invalid @enderror">
                                    <option value="training" {{ old('inquiry_type') == 'training' ? 'selected' : '' }}>Training</option>
                                    <option value="corporate" {{ old('inquiry_type') == 'corporate' ? 'selected' : '' }}>Corporate</option>
                                    <option value="university" {{ old('inquiry_type') == 'university' ? 'selected' : '' }}>University</option>
                                    <option value="other" {{ old('inquiry_type') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('inquiry_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                
                        <div class="col-12">
                            <div class="form-group">
                                <label class="am-label">Message</label>
                                <textarea name="message" class="form-control am-input @error('message') is-invalid @enderror" 
                                          rows="4" placeholder="How can we help you?">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                
                        <div class="col-12 text-end mt-4">
                            <button type="submit" class="am-btn am-btn-primary">Submit Inquiry</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* main.css এর সাথে মিল রেখে কাস্টম টিউনিং */
    .am-contact-wrapper { background-color: #f8f9fa; }
    .am-icon-box {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(var(--primary-rgb, 0, 123, 255), 0.1);
        color: var(--primary-color, #007bff);
        border-radius: 8px;
    }
    .am-social-btn {
        font-size: 1.2rem;
        transition: transform 0.3s ease;
        display: inline-block;
    }
    .am-social-btn:hover { transform: translateY(-3px); }
    .am-input {
        border: 1px solid #dee2e6;
        padding: 0.75rem 1rem;
        border-radius: 6px;
    }
    .am-input:focus {
        border-color: var(--primary-color);
        box-shadow: none;
    }
    .am-btn-primary {
        padding: 12px 30px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>
@endsection