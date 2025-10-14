@extends('layouts.app')

@section('content')
<div class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $page->banner_title }}</h1>
            @if($page->last_updated)
                <p class="text-lg text-gray-600">
                    Last Updated: {{ \Carbon\Carbon::parse($page->last_updated)->format('F j, Y') }}
                </p>
            @endif
        </div>

        <div class="prose prose-lg max-w-none text-gray-600">
            <div class="mb-12">
                <div class="prose max-w-none">
                    {!! $page->introduction_content !!}
                </div>
            </div>

            @if($page->information_collected_title && $page->information_collected_content)
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">{{ $page->information_collected_title }}</h2>
                    <div class="prose max-w-none">
                        {!! $page->information_collected_content !!}
                    </div>
                </div>
            @endif

            @if($page->how_we_use_title && $page->how_we_use_content)
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">{{ $page->how_we_use_title }}</h2>
                    <div class="prose max-w-none">
                        {!! $page->how_we_use_content !!}
                    </div>
                </div>
            @endif

            @if($page->how_we_share_title && $page->how_we_share_content)
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">{{ $page->how_we_share_title }}</h2>
                    <div class="prose max-w-none">
                        {!! $page->how_we_share_content !!}
                    </div>
                </div>
            @endif

            @if($page->data_security_title && $page->data_security_content)
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">{{ $page->data_security_title }}</h2>
                    <div class="prose max-w-none">
                        {!! $page->data_security_content !!}
                    </div>
                </div>
            @endif

            @if($page->your_rights_title && $page->your_rights_content)
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">{{ $page->your_rights_title }}</h2>
                    <div class="prose max-w-none">
                        {!! $page->your_rights_content !!}
                    </div>
                </div>
            @endif

            <div class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Cookies and Tracking Technologies</h2>
                <p class="mb-4">
                    We use cookies and similar tracking technologies to track activity on our website and hold certain information. You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, you may not be able to use some portions of our website.
                </p>
            </div>

            <div class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Third-Party Links</h2>
                <p class="mb-4">
                    Our website may contain links to third-party websites. We are not responsible for the privacy practices or the content of such websites. We encourage you to read the privacy policies of any linked websites you visit.
                </p>
            </div>

            <div class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Children's Privacy</h2>
                <p class="mb-4">
                    Our website is not intended for individuals under the age of 18. We do not knowingly collect personal information from children. If you are a parent or guardian and believe that your child has provided us with personal information, please contact us.
                </p>
            </div>

            @if($page->policy_changes_title && $page->policy_changes_content)
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">{{ $page->policy_changes_title }}</h2>
                    <div class="prose max-w-none">
                        {!! $page->policy_changes_content !!}
                    </div>
                </div>
            @endif

            @if($page->contact_us_title && $page->contact_us_content)
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">{{ $page->contact_us_title }}</h2>
                    <div class="prose max-w-none">
                        {!! $page->contact_us_content !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
