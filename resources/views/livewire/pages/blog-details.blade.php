<div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css" />
    <section class="am-blogdetail">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="am-blogdetail_content">
                        <figure class="am-blogdetail_banner am-blogdetail-img">
                            <img src="{{ url(Storage::url($blog->image)) }}" alt="{{ $blog->title }}" />
                        </figure>
                        <div class="am-titlebox">
                            @if(!empty($blog->categories))
                            <ul>
                                @foreach ($blog->categories as $category)
                                    <li><a href="{{ route('blogs', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
                                @endforeach
                            </ul>  
                            @endif
                            <h2>{{ $blog->title }}</h2>
                            <div class="am-calender">
                                <span><i class="am-icon-calender"></i>{{ $blog->updated_at->format('M d, Y') }}</span>
                                @if (!empty($blog->views_count))
                                
                                    <span><i class="am-icon-eye-open-01"></i>{{ number_format($blog->views_count) }} {{$blog->views_count == 1 ?  __('blogs.view') : __('blogs.views') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="am-blogdetail_description am-description-content">
                            {!! $blog->description !!}
                        </div>
                       @if (!empty($blog->tags))
                        <div class="am-meta-tags">
                            <h4>{{ __('blogs.tags') }}:</h4>
                            <ul>
                                @foreach ($blog->tags as $tag)
                                    <li>
                                        <span>{{ $tag->name }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                       @endif
                       @if(!empty($blog->author?->profile))
                            <div class="am-author">
                                <div class="am-title-box">
                                    @if (!empty($blog->author->profile->image))
                                    <figure>
                                        <img src="{{ url(Storage::url($blog->author->profile->image)) }}" alt="{{ $blog->author?->profile?->full_name }}" />
                                    </figure>
                                    @endif
                                    @if (!empty($blog->author?->profile?->short_name))
                                    <div class="am-title">
                                        <span>{{ __('blogs.author') }}</span>
                                            <h4>{{ $blog->author?->profile->short_name }}</h4>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                    @if (!empty($relatedBlogs) && $relatedBlogs->isNotEmpty())
                        <div class="am-articles-area">
                            <h2>{{ __('blogs.explore_related_articles') }}</h2>
                            <div class="row gy-4">
                                @foreach($relatedBlogs as $relatedBlog)
                                    <div class="col-12 col-md-6 col-lg-6 col-xl-4 col-xxl-3">
                                        <div class="am-article">
                                            <figure class="am-article-img">
                                                <img src="{{ url(Storage::url($relatedBlog->image)) }}" alt="{{ $blog->title }}">
                                            </figure>
                                            <div class="am-article-content">
                                                @if(!empty($relatedBlog->categories))
                                                    <div class="am-categorie-name">
                                                        @foreach ($relatedBlog->categories as $category)
                                                        <a href="{{ route('blogs', ['category' => $category->slug]) }}"><span>{{ $category->name }}{{ !$loop->last ? ',' : '' }}</span></a>
                                                        @endforeach
                                                    </div>
                                                @endif
                                                @if (!empty($relatedBlog->title))
                                                    <a href="{{ route('blog-details', $relatedBlog->slug) }}"><h3>{{ $relatedBlog->title }}</h3></a>
                                                @endif
                                                @if (!empty($relatedBlog->description))
                                                    <p>{{ Str::limit(strip_tags($relatedBlog->description), 100) }}</p>
                                                @endif
                                                <div class="am-userand-date">
                                                    <div class="am-user-box">
                                                        <figure>
                                                            <img src="{{ url(Storage::url($relatedBlog->author?->profile?->image)) }}" alt="{{ $relatedBlog->author?->profile?->full_name }}">
                                                        </figure>
                                                        @if (!empty($relatedBlog->author?->profile?->short_name))
                                                        <h4>{{ $relatedBlog->author?->profile->short_name }}</h4>
                                                        @endif
                                                    </div>
                                                    <em>{{ $relatedBlog->updated_at->format('M d, Y') }}</em>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

