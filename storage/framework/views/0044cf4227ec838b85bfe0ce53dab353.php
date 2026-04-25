

<?php $__env->startSection('content'); ?>
<div class="am-contact-wrapper py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 text-center mb-5">
                <div class="am-section-head">
                    <h2 class="am-title">Get in Touch</h2>
                    <p class="am-desc">For training inquiries, corporate programs, or university collaboration, please contact us[cite: 1, 53].</p>
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
                                    <a href="tel:+8801742719724" class="am-link">+880 1742 719724</a> [cite: 65, 68]
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
                                    <p class="mb-0">Online & Physical Training</p> [cite: 111, 214]
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
                    <form action="#" class="am-custom-form">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="am-label">Full Name *</label>
                                    <input type="text" class="form-control am-input" placeholder="Enter your name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="am-label">Email Address *</label>
                                    <input type="email" class="form-control am-input" placeholder="Enter your email" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="am-label">Contact Number *</label>
                                    <input type="text" class="form-control am-input" placeholder="Enter phone number" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="am-label">Organization / University</label>
                                    <input type="text" class="form-control am-input" placeholder="Enter institution name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="am-label">Designation</label>
                                    <input type="text" class="form-control am-input" placeholder="Enter your role">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="am-label">Type of Inquiry</label>
                                    <select class="form-select am-input shadow-none">
                                        <option value="training">Training</option>
                                        <option value="corporate">Corporate</option>
                                        <option value="university">University</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="am-label">Message</label>
                                    <textarea class="form-control am-input" rows="4" placeholder="How can we help you?"></textarea>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend-app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/test.blade.php ENDPATH**/ ?>