@extends('layouts.template')

@section('title', 'Privacy Policy')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <h1 class="mb-4">Privacy Policy</h1>
                    <p class="text-muted">Last updated: April 27, 2025</p>
                    
                    <div class="mb-5">
                        <p>At Guide Touristique Local, we take your privacy seriously. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website or use our services.</p>
                    </div>
                    
                    <div class="mb-4">
                        <h4>1. Information We Collect</h4>
                        <p>We may collect information about you in various ways, including:</p>
                        <ul>
                            <li><strong>Personal Data:</strong> Name, email address, phone number, postal address, payment information, and other information you provide when creating an account or booking a tour.</li>
                            <li><strong>Usage Data:</strong> Information about how you use our website and services, including IP address, browser type, pages visited, and time spent on our site.</li>
                            <li><strong>Location Data:</strong> With your consent, we may collect precise location data to provide location-based services.</li>
                        </ul>
                    </div>
                    
                    <div class="mb-4">
                        <h4>2. How We Use Your Information</h4>
                        <p>We may use the information we collect for various purposes, including:</p>
                        <ul>
                            <li>Providing and maintaining our services</li>
                            <li>Processing your bookings and payments</li>
                            <li>Communicating with you about your account or bookings</li>
                            <li>Sending you marketing and promotional materials (with your consent)</li>
                            <li>Improving our website and services</li>
                            <li>Analyzing usage patterns and trends</li>
                            <li>Detecting and preventing fraud or abuse</li>
                        </ul>
                    </div>
                    
                    <div class="mb-4">
                        <h4>3. Sharing Your Information</h4>
                        <p>We may share your information with:</p>
                        <ul>
                            <li><strong>Guides:</strong> When you book a tour, we share your information with the relevant guide to facilitate the service.</li>
                            <li><strong>Service Providers:</strong> We may share your information with third-party service providers who perform services on our behalf, such as payment processing and data analysis.</li>
                            <li><strong>Legal Requirements:</strong> We may disclose your information if required by law or in response to valid requests by public authorities.</li>
                        </ul>
                    </div>
                    
                    <div class="mb-4">
                        <h4>4. Data Security</h4>
                        <p>We implement appropriate technical and organizational measures to protect your personal data against unauthorized access, alteration, disclosure, or destruction. However, no method of transmission over the Internet or electronic storage is 100% secure, and we cannot guarantee absolute security.</p>
                    </div>
                    
                    <div class="mb-4">
                        <h4>5. Your Data Protection Rights</h4>
                        <p>Depending on your location, you may have the following rights regarding your personal data:</p>
                        <ul>
                            <li>The right to access your personal data</li>
                            <li>The right to rectify inaccurate or incomplete data</li>
                            <li>The right to erasure ("right to be forgotten")</li>
                            <li>The right to restrict processing</li>
                            <li>The right to data portability</li>
                            <li>The right to object to processing</li>
                            <li>The right to withdraw consent</li>
                        </ul>
                        <p>To exercise these rights, please contact us using the information provided at the end of this policy.</p>
                    </div>
                    
                    <div class="mb-4">
                        <h4>6. Cookies and Tracking Technologies</h4>
                        <p>We use cookies and similar tracking technologies to collect and use information about you and your interaction with our website. You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent.</p>
                    </div>
                    
                    <div class="mb-4">
                        <h4>7. Children's Privacy</h4>
                        <p>Our services are not intended for individuals under the age of 18. We do not knowingly collect personal data from children. If we become aware that we have collected personal data from a child without verification of parental consent, we will take steps to remove that information from our servers.</p>
                    </div>
                    
                    <div class="mb-4">
                        <h4>8. Changes to This Privacy Policy</h4>
                        <p>We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last updated" date.</p>
                    </div>
                    
                    <div class="mt-5">
                        <h4>Contact Us</h4>
                        <p>If you have any questions about this Privacy Policy, please contact us:</p>
                        <ul>
                            <li>By email: <a href="mailto:privacy@geonomad.com">privacy@geonomad.com</a></li>
                            <li>By visiting the contact page on our website: <a href="{{ route('contact') }}">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection