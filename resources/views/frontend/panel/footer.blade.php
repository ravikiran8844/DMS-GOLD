@php
    $setting = App\Models\Settings::first();
@endphp
<section class="footer-links-section mt-5">
    <div class="container py-5 px-lg-5">
        <div class="row">
            <div class="col mt-2">
                <div class="footer-links">
                    <div class="mb-4 footer-links_title">{{ $setting->east_zone_name }}</div>
                    <ul class="list-unstyled">
                        <li class="footer-links_link"><span><svg xmlns="http://www.w3.org/2000/svg" width="21"
                                    height="21" viewBox="0 0 21 21" fill="none">
                                    <path
                                        d="M19.8625 13.432C19.8625 14.576 18.9 15.544 17.7625 15.544H5.33745L1.13745 19.768V3.04803C1.13745 1.90404 2.09995 0.936035 3.23745 0.936035H17.85C18.9875 0.936035 19.95 1.90404 19.95 3.04803V13.432H19.8625Z"
                                        stroke="#F78D1E" stroke-linecap="round" stroke-linejoin="round" />
                                </svg></span> {{ $setting->east_zone_incharge_name }}
                        </li>
                        <li class="footer-links_link"><span><svg width="22" height="23" viewBox="0 0 22 23"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M21.2857 16.9555V20.1555C21.2857 21.3111 20.3429 22.2889 19.2286 22.2889C19.1429 22.2889 19.0571 22.2889 19.0571 22.2889C15.8857 21.9333 12.8 20.7778 10.1429 19C7.65714 17.4 5.51428 15.1778 3.97143 12.6C2.17143 9.84443 1.05714 6.64443 0.714284 3.35554C0.62857 2.1111 1.48571 1.13332 2.6 1.04443C2.68571 1.04443 2.68571 1.04443 2.77143 1.04443H5.85714C6.88571 1.04443 7.74286 1.84443 7.91428 2.9111C8.08571 3.97777 8.25714 4.95554 8.6 5.93332C8.85714 6.73332 8.68571 7.62221 8.17143 8.15554L6.88571 9.48888C8.34286 12.1555 10.4857 14.3778 13.0571 15.8889L14.3429 14.5555C14.9429 13.9333 15.8 13.7555 16.4857 14.1111C17.4286 14.4667 18.3714 14.7333 19.4 14.8222C20.5143 14.9111 21.2857 15.8889 21.2857 16.9555Z"
                                        stroke="#F78D1E" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span> <a href="tel:{{ $setting->east_zone_mobile_no }}"
                                class="text-decoration-none">{{ $setting->east_zone_mobile_no }}</a>
                        </li>
                        <li class="footer-links_link"><span><svg width="24" height="18" viewBox="0 0 24 18"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M22.2857 1.28662H1.7135C1.4768 1.28662 1.28491 1.47851 1.28491 1.71521V16.2872C1.28491 16.5239 1.4768 16.7157 1.7135 16.7157H22.2857C22.5224 16.7157 22.7142 16.5239 22.7142 16.2872V1.71521C22.7142 1.47851 22.5224 1.28662 22.2857 1.28662Z"
                                        stroke="#F78D1E" />
                                    <path
                                        d="M22.4974 1.49927L12.2867 12.4548C12.2517 12.4925 12.2092 12.5226 12.162 12.5431C12.1148 12.5637 12.0639 12.5743 12.0124 12.5743C11.961 12.5743 11.91 12.5637 11.8628 12.5431C11.8156 12.5226 11.7732 12.4925 11.7381 12.4548L1.50092 1.49927"
                                        stroke="#F78D1E" />
                                </svg>
                            </span> <a href="mailto:{{ $setting->east_zone_incharge_email }}"
                                class="text-decoration-none">{{ $setting->east_zone_incharge_email }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col mt-2">
                <div class="footer-links">
                    <div class="mb-4 footer-links_title">{{ $setting->west_zone_name }}</div>
                    <ul class="list-unstyled">
                        <li class="footer-links_link"><span><svg xmlns="http://www.w3.org/2000/svg" width="21"
                                    height="21" viewBox="0 0 21 21" fill="none">
                                    <path
                                        d="M19.8625 13.432C19.8625 14.576 18.9 15.544 17.7625 15.544H5.33745L1.13745 19.768V3.04803C1.13745 1.90404 2.09995 0.936035 3.23745 0.936035H17.85C18.9875 0.936035 19.95 1.90404 19.95 3.04803V13.432H19.8625Z"
                                        stroke="#F78D1E" stroke-linecap="round" stroke-linejoin="round" />
                                </svg></span> {{ $setting->west_zone_incharge_name }}
                        </li>
                        <li class="footer-links_link"><span><svg width="22" height="23" viewBox="0 0 22 23"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M21.2857 16.9555V20.1555C21.2857 21.3111 20.3429 22.2889 19.2286 22.2889C19.1429 22.2889 19.0571 22.2889 19.0571 22.2889C15.8857 21.9333 12.8 20.7778 10.1429 19C7.65714 17.4 5.51428 15.1778 3.97143 12.6C2.17143 9.84443 1.05714 6.64443 0.714284 3.35554C0.62857 2.1111 1.48571 1.13332 2.6 1.04443C2.68571 1.04443 2.68571 1.04443 2.77143 1.04443H5.85714C6.88571 1.04443 7.74286 1.84443 7.91428 2.9111C8.08571 3.97777 8.25714 4.95554 8.6 5.93332C8.85714 6.73332 8.68571 7.62221 8.17143 8.15554L6.88571 9.48888C8.34286 12.1555 10.4857 14.3778 13.0571 15.8889L14.3429 14.5555C14.9429 13.9333 15.8 13.7555 16.4857 14.1111C17.4286 14.4667 18.3714 14.7333 19.4 14.8222C20.5143 14.9111 21.2857 15.8889 21.2857 16.9555Z"
                                        stroke="#F78D1E" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span> <a href="tel:{{ $setting->west_zone_mobile_no }}"
                                class="text-decoration-none">{{ $setting->west_zone_mobile_no }}</a>
                        </li>
                        <li class="footer-links_link"><span><svg width="24" height="18" viewBox="0 0 24 18"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M22.2857 1.28662H1.7135C1.4768 1.28662 1.28491 1.47851 1.28491 1.71521V16.2872C1.28491 16.5239 1.4768 16.7157 1.7135 16.7157H22.2857C22.5224 16.7157 22.7142 16.5239 22.7142 16.2872V1.71521C22.7142 1.47851 22.5224 1.28662 22.2857 1.28662Z"
                                        stroke="#F78D1E" />
                                    <path
                                        d="M22.4974 1.49927L12.2867 12.4548C12.2517 12.4925 12.2092 12.5226 12.162 12.5431C12.1148 12.5637 12.0639 12.5743 12.0124 12.5743C11.961 12.5743 11.91 12.5637 11.8628 12.5431C11.8156 12.5226 11.7732 12.4925 11.7381 12.4548L1.50092 1.49927"
                                        stroke="#F78D1E" />
                                </svg>
                            </span> <a href="mailto:{{ $setting->west_zone_incharge_email }}"
                                class="text-decoration-none">{{ $setting->west_zone_incharge_email }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col mt-2">
                <div class="footer-links">
                    <div class="mb-4 footer-links_title">{{ $setting->north_zone_name }}</div>
                    <ul class="list-unstyled">
                        <li class="footer-links_link"><span><svg xmlns="http://www.w3.org/2000/svg" width="21"
                                    height="21" viewBox="0 0 21 21" fill="none">
                                    <path
                                        d="M19.8625 13.432C19.8625 14.576 18.9 15.544 17.7625 15.544H5.33745L1.13745 19.768V3.04803C1.13745 1.90404 2.09995 0.936035 3.23745 0.936035H17.85C18.9875 0.936035 19.95 1.90404 19.95 3.04803V13.432H19.8625Z"
                                        stroke="#F78D1E" stroke-linecap="round" stroke-linejoin="round" />
                                </svg></span> {{ $setting->north_zone_incharge_name }}
                        </li>
                        <li class="footer-links_link"><span><svg width="22" height="23" viewBox="0 0 22 23"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M21.2857 16.9555V20.1555C21.2857 21.3111 20.3429 22.2889 19.2286 22.2889C19.1429 22.2889 19.0571 22.2889 19.0571 22.2889C15.8857 21.9333 12.8 20.7778 10.1429 19C7.65714 17.4 5.51428 15.1778 3.97143 12.6C2.17143 9.84443 1.05714 6.64443 0.714284 3.35554C0.62857 2.1111 1.48571 1.13332 2.6 1.04443C2.68571 1.04443 2.68571 1.04443 2.77143 1.04443H5.85714C6.88571 1.04443 7.74286 1.84443 7.91428 2.9111C8.08571 3.97777 8.25714 4.95554 8.6 5.93332C8.85714 6.73332 8.68571 7.62221 8.17143 8.15554L6.88571 9.48888C8.34286 12.1555 10.4857 14.3778 13.0571 15.8889L14.3429 14.5555C14.9429 13.9333 15.8 13.7555 16.4857 14.1111C17.4286 14.4667 18.3714 14.7333 19.4 14.8222C20.5143 14.9111 21.2857 15.8889 21.2857 16.9555Z"
                                        stroke="#F78D1E" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span> <a href="tel:{{ $setting->north_zone_mobile_no }}"
                                class="text-decoration-none">{{ $setting->north_zone_mobile_no }}</a>
                        </li>
                        <li class="footer-links_link"><span><svg width="24" height="18" viewBox="0 0 24 18"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M22.2857 1.28662H1.7135C1.4768 1.28662 1.28491 1.47851 1.28491 1.71521V16.2872C1.28491 16.5239 1.4768 16.7157 1.7135 16.7157H22.2857C22.5224 16.7157 22.7142 16.5239 22.7142 16.2872V1.71521C22.7142 1.47851 22.5224 1.28662 22.2857 1.28662Z"
                                        stroke="#F78D1E" />
                                    <path
                                        d="M22.4974 1.49927L12.2867 12.4548C12.2517 12.4925 12.2092 12.5226 12.162 12.5431C12.1148 12.5637 12.0639 12.5743 12.0124 12.5743C11.961 12.5743 11.91 12.5637 11.8628 12.5431C11.8156 12.5226 11.7732 12.4925 11.7381 12.4548L1.50092 1.49927"
                                        stroke="#F78D1E" />
                                </svg>
                            </span> <a href="mailto:{{ $setting->north_zone_incharge_email }}"
                                class="text-decoration-none">{{ $setting->north_zone_incharge_email }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col mt-2">
                <div class="footer-links">
                    <div class="mb-4 footer-links_title">{{ $setting->south_zone_name }}</div>
                    <ul class="list-unstyled">
                        <li class="footer-links_link"><span><svg xmlns="http://www.w3.org/2000/svg" width="21"
                                    height="21" viewBox="0 0 21 21" fill="none">
                                    <path
                                        d="M19.8625 13.432C19.8625 14.576 18.9 15.544 17.7625 15.544H5.33745L1.13745 19.768V3.04803C1.13745 1.90404 2.09995 0.936035 3.23745 0.936035H17.85C18.9875 0.936035 19.95 1.90404 19.95 3.04803V13.432H19.8625Z"
                                        stroke="#F78D1E" stroke-linecap="round" stroke-linejoin="round" />
                                </svg></span> {{ $setting->south_zone_incharge_name }}
                        </li>
                        <li class="footer-links_link"><span><svg width="22" height="23" viewBox="0 0 22 23"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M21.2857 16.9555V20.1555C21.2857 21.3111 20.3429 22.2889 19.2286 22.2889C19.1429 22.2889 19.0571 22.2889 19.0571 22.2889C15.8857 21.9333 12.8 20.7778 10.1429 19C7.65714 17.4 5.51428 15.1778 3.97143 12.6C2.17143 9.84443 1.05714 6.64443 0.714284 3.35554C0.62857 2.1111 1.48571 1.13332 2.6 1.04443C2.68571 1.04443 2.68571 1.04443 2.77143 1.04443H5.85714C6.88571 1.04443 7.74286 1.84443 7.91428 2.9111C8.08571 3.97777 8.25714 4.95554 8.6 5.93332C8.85714 6.73332 8.68571 7.62221 8.17143 8.15554L6.88571 9.48888C8.34286 12.1555 10.4857 14.3778 13.0571 15.8889L14.3429 14.5555C14.9429 13.9333 15.8 13.7555 16.4857 14.1111C17.4286 14.4667 18.3714 14.7333 19.4 14.8222C20.5143 14.9111 21.2857 15.8889 21.2857 16.9555Z"
                                        stroke="#F78D1E" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span> <a href="tel:{{ $setting->south_zone_mobile_no }}"
                                class="text-decoration-none">{{ $setting->south_zone_mobile_no }}</a>
                        </li>
                        <li class="footer-links_link"><span><svg width="24" height="18" viewBox="0 0 24 18"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M22.2857 1.28662H1.7135C1.4768 1.28662 1.28491 1.47851 1.28491 1.71521V16.2872C1.28491 16.5239 1.4768 16.7157 1.7135 16.7157H22.2857C22.5224 16.7157 22.7142 16.5239 22.7142 16.2872V1.71521C22.7142 1.47851 22.5224 1.28662 22.2857 1.28662Z"
                                        stroke="#F78D1E" />
                                    <path
                                        d="M22.4974 1.49927L12.2867 12.4548C12.2517 12.4925 12.2092 12.5226 12.162 12.5431C12.1148 12.5637 12.0639 12.5743 12.0124 12.5743C11.961 12.5743 11.91 12.5637 11.8628 12.5431C11.8156 12.5226 11.7732 12.4925 11.7381 12.4548L1.50092 1.49927"
                                        stroke="#F78D1E" />
                                </svg>
                            </span> <a href="mailto{{ $setting->south_zone_incharge_email }}"
                                class="text-decoration-none">{{ $setting->south_zone_incharge_email }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="col-12 py-2 text-center copyright-text">
    <div>
        Emerald © <span id="current-year"></span> All Rights Reserved.
        Developed By <a href="https://brightbridge.co/" class="text-decoration-none" target="_blank">BBIT</a>
    </div>
</div>
<style>
    .text-decoration-none {
        text-decoration: none !important;
        color: #565656;
    }
</style>
<script>
    let year = new Date().getFullYear()
    document.getElementById("current-year").textContent = year;
</script>
