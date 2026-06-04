<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopSwift</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        .scroll-reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity .7s ease, transform .7s ease;
        }

        .scroll-reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .toast-in {
            animation: toastIn .45s ease forwards;
        }

        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translateY(-16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-white text-[#111827] pb-20 md:pb-0 overflow-x-hidden">

@if (session('cart_success'))
    <div id="cartToast"
         class="toast-in fixed top-20 left-4 right-4 sm:left-auto sm:right-6 sm:w-[360px] z-[999] bg-white border border-gray-200 shadow-xl rounded-2xl px-5 py-4 flex items-center gap-3">
        <div class="w-9 h-9 shrink-0 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold">
            ✓
        </div>
        <div class="min-w-0">
            <div class="font-bold">カートに追加しました</div>
            <div class="text-sm text-gray-500 truncate">{{ session('cart_success') }}</div>
        </div>
    </div>
@endif

@if (session('success'))
    <div id="favorite" class="fixed top-20 left-4 right-4 sm:left-auto sm:right-6 sm:w-[360px] z-[999] bg-white border border-gray-200 shadow-xl rounded-2xl px-5 py-4">
        <div class="font-bold text-green-700">
            {{ session('success') }}
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="fixed top-20 left-4 right-4 sm:left-auto sm:right-6 sm:w-[360px] z-[999] bg-white border border-red-200 shadow-xl rounded-2xl px-5 py-4 text-red-600">
        @foreach ($errors->all() as $error)
            <p class="text-sm font-bold">{{ $error }}</p>
        @endforeach
    </div>
@endif

<x-site-header />

<main class="max-w-[1500px] mx-auto px-4 sm:px-6 md:px-8 py-8">

    <section class="grid grid-cols-1 lg:grid-cols-2 items-center gap-8 mb-16 md:mb-24 scroll-reveal">
        <div class="py-6 md:py-12">
            <p class="text-gray-500 mb-5">About ShopSwift</p>

            @auth
                <div class="inline-flex items-center gap-2 bg-green-50 text-green-700 px-4 py-2 rounded-full text-sm font-bold mb-6">
                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                    ログイン中：{{ auth()->user()->name }} 様
                </div>
            @endauth

            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold leading-tight mb-8">
                暮らしを、<br>
                もっと心地よく。
            </h1>

            <p class="text-gray-700 leading-loose mb-6 max-w-xl">
                ShopSwiftは、毎日の暮らしを心地よくするアイテムを、厳選してお届けするオンラインストアです。
            </p>

            <p class="text-gray-700 leading-loose mb-10 max-w-xl">
                シンプルで長く使えるもの、環境や人にやさしいものを中心に、あなたの「ちょうどいい」に寄り添います。
            </p>

            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('products.all') }}"
                   class="inline-flex items-center justify-center gap-3 bg-[#070d16] text-white px-8 py-4 rounded-xl font-bold hover:bg-gray-800">
                    全商品を見る
                    <span>›</span>
                </a>

                @auth
                    <a href="{{ route('mypage') }}"
                       class="inline-flex items-center justify-center gap-3 border border-gray-300 px-8 py-4 rounded-xl font-bold hover:bg-gray-50">
                        マイページへ
                    </a>
                @else
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center justify-center gap-3 border border-gray-300 px-8 py-4 rounded-xl font-bold hover:bg-gray-50">
                        新規会員登録
                    </a>
                @endauth
            </div>
        </div>

        <div class="min-h-[280px] sm:min-h-[360px] md:min-h-[500px] bg-[#f4eee6] rounded-3xl overflow-hidden flex items-center justify-center">
                 <img
        src="{{ asset('about/images/lifestyle.png') }}"
        alt="ShopSwiftのミッション"
        class="w-full h-[220px] md:h-[360px] object-cover object-center block"
    >
            </div>
        </div>
    </section>

    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 md:gap-6 mb-16 md:mb-24 scroll-reveal">
        <div class="bg-white border border-gray-100 rounded-2xl p-5 flex items-start gap-4">
            <i data-lucide="leaf" class="w-8 h-8 shrink-0"></i>
            <div>
                <div class="font-bold mb-2">厳選されたアイテム</div>
                <p class="text-sm text-gray-500 leading-relaxed">本当に良いものだけをセレクト。</p>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-2xl p-5 flex items-start gap-4">
            <i data-lucide="heart" class="w-8 h-8 shrink-0"></i>
            <div>
                <div class="font-bold mb-2">やさしい選択</div>
                <p class="text-sm text-gray-500 leading-relaxed">環境や人に配慮したものづくり。</p>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-2xl p-5 flex items-start gap-4">
            <i data-lucide="headphones" class="w-8 h-8 shrink-0"></i>
            <div>
                <div class="font-bold mb-2">安心のサポート</div>
                <p class="text-sm text-gray-500 leading-relaxed">購入前から購入後まで丁寧に対応。</p>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-2xl p-5 flex items-start gap-4">
            <i data-lucide="truck" class="w-8 h-8 shrink-0"></i>
            <div>
                <div class="font-bold mb-2">送料無料</div>
                <p class="text-sm text-gray-500 leading-relaxed">¥10,000以上のご注文で送料無料。通常¥220</p>
            </div>
        </div>
    </section>

    <section class="bg-[#f8f4ef] rounded-3xl overflow-hidden mb-12 md:mb-16 scroll-reveal">
        <div class="grid grid-cols-1 lg:grid-cols-2 items-center">
            <div class="p-6 sm:p-8 md:p-12">
                <h2 class="text-2xl md:text-3xl font-bold mb-6">
                    ShopSwiftのミッション
                </h2>

                <div class="space-y-4 text-gray-700 leading-loose">
                    <p>私たちは、モノを通して「心地よい暮らし」を届けることを使命としています。</p>
                    <p>日々の暮らしにそっと寄り添い、使うたびにうれしくなるような体験を提供します。</p>
                    <p>シンプルで美しく、長く使えること。環境にやさしく、人にもやさしいこと。</p>
                    <p>その両方を大切にしながら、持続可能な社会の実現に貢献していきます。</p>
                </div>
            </div>

            <div class="min-h-[220px] md:min-h-[360px] bg-[#eadfd2] flex items-center justify-center">
                  <img
        src="{{ asset('about/images/mission.png') }}"
        alt="ShopSwiftのミッション"
        class="w-full h-[220px] md:h-[360px] object-cover object-center block"
    >
            </div>
        </div>
    </section>

    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8 mb-16 md:mb-24 scroll-reveal">
        <div class="bg-[#f7f1ea] rounded-3xl min-h-[240px] md:min-h-[280px] flex items-center justify-center">
                        <img
        src="{{ asset('about/images/office.png') }}"
        alt="ShopSwiftのミッション"
        class="w-full h-[220px] md:h-[360px] object-cover object-center block"
    >
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 p-6 md:p-8">
            <h2 class="text-2xl font-bold mb-6">取り扱いのこだわり</h2>

            <div class="space-y-6">
                <div class="flex gap-4">
                    <i data-lucide="tag" class="w-6 h-6 shrink-0"></i>
                    <div>
                        <div class="font-bold">シンプルで長く使えるデザイン</div>
                        <p class="text-sm text-gray-500 mt-1">流行に左右されず、暮らしに自然となじむアイテムを。</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <i data-lucide="sprout" class="w-6 h-6 shrink-0"></i>
                    <div>
                        <div class="font-bold">環境に配慮したものづくり</div>
                        <p class="text-sm text-gray-500 mt-1">環境負荷の少ない商品を選びます。</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <i data-lucide="shield-check" class="w-6 h-6 shrink-0"></i>
                    <div>
                        <div class="font-bold">確かな品質をお手頃に</div>
                        <p class="text-sm text-gray-500 mt-1">品質と価格のバランスを追求します。</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 p-6 md:p-8">
            <h2 class="text-2xl font-bold mb-4">ShopSwiftについて</h2>

            <h3 class="text-xl font-bold mb-4">暮らしを、もっと心地よく。</h3>

            <p class="text-gray-600 leading-loose mb-6">
                ShopSwiftは、毎日の暮らしを心地よくするアイテムを厳選してお届けするオンラインストアです。
            </p>

            <div class="space-y-3 text-sm text-gray-700 mb-6">
                <div>ShopSwift株式会社</div>
                <div>東京都渋谷区〇〇1-2-3</div>
                <div>2024年設立</div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <a href="{{ route('contact.index') }}" class="border rounded-xl py-3 text-center text-sm font-bold">お問い合わせ</a>
                <a href="{{ route('terms') }}" class="border rounded-xl py-3 text-center text-sm font-bold">利用規約</a>
            </div>
        </div>
    </section>

    <section id="products" class="mb-16 md:mb-24 scroll-reveal">
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-10">
            <div class="max-w-3xl">
                <div class="text-gray-500 mb-3">
                    Featured Products
                </div>

                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4 leading-tight">
                    人気商品
                </h2>

                <p class="text-gray-500 leading-relaxed">
                    多くのお客様にご好評いただいている商品を掲載しています。
                </p>
            </div>

            <a href="{{ route('products.all') }}"
               class="inline-flex items-center justify-center gap-2 bg-[#070d16] text-white px-6 py-4 rounded-xl font-bold hover:bg-gray-800 transition">
                全商品を見る
                <span>→</span>
            </a>
        </div>

        @if ($products->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-7 justify-items-start">
                @foreach ($products as $product)
                    <div class="group w-full bg-white border border-gray-200 rounded-3xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition duration-500">
                        <a href="{{ route('products.show', $product) }}" class="block">
                            <div class="relative h-56 sm:h-64 bg-[#f4eee6] flex items-center justify-center overflow-hidden">
                                <span class="absolute top-4 left-4 z-10 bg-black text-white rounded-full px-3 py-1 text-xs font-bold">
                                    人気商品
                                </span>

                                @if ($product->image_path)
                                    <img src="{{ asset('storage/' . $product->image_path) }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                                @else
                                    <div class="text-6xl">📦</div>
                                @endif
                            </div>

                            <div class="p-5">
                                <div class="text-sm text-gray-500 mb-2">
                                    {{ $product->category ?? 'ShopSwift Select' }}
                                </div>

                                <h3 class="font-bold text-lg mb-2 line-clamp-2">
                                    {{ $product->name }}
                                </h3>

                                <div class="font-bold text-xl mb-2">
                                    ¥{{ number_format($product->price) }}
                                    <span class="text-xs text-gray-400">税込</span>
                                </div>

                                <div class="text-yellow-400 text-sm mb-4">
                                    ★★★★★ <span class="text-gray-500">4.6</span>
                                </div>

                                <p class="text-sm text-gray-600 leading-relaxed mb-5 line-clamp-2">
                                    {{ mb_strimwidth($product->description ?? '', 0, 64, '...') }}
                                </p>
                            </div>
                        </a>

                        <div class="px-5 pb-5 flex gap-3">
                            <a href="{{ route('products.show', $product) }}"
                               class="w-12 h-12 shrink-0 border border-gray-300 rounded-xl flex items-center justify-center hover:bg-gray-50 transition">
                                <i data-lucide="eye" class="w-5 h-5"></i>
                            </a>
                                                        @auth
                                @php
                                    $isFavorited = $product->favorites->contains('user_id', auth()->id());
                                @endphp

                                <form method="POST"
                                    action="{{ route('favorites.toggle', $product) }}">
                                    @csrf

                                    <button type="submit"
                                            class="w-12 h-12 shrink-0 border rounded-xl flex items-center justify-center transition
                                                {{ $isFavorited
                                                    ? 'bg-red-50 border-red-200 text-red-500'
                                                    : 'border-gray-300 hover:bg-gray-50 text-gray-700'
                                                }}">
                                        <i data-lucide="heart"
                                        class="w-5 h-5 {{ $isFavorited ? 'fill-current' : '' }}"></i>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}"
                                class="w-12 h-12 shrink-0 border border-gray-300 rounded-xl flex items-center justify-center hover:bg-gray-50 transition">
                                    <i data-lucide="heart" class="w-5 h-5"></i>
                                </a>
                            @endauth
                            @auth
                                <form method="POST"
                                      action="{{ route('cart.store', $product) }}"
                                      class="flex-1">
                                    @csrf

                                    <button type="submit"
                                            class="w-full h-12 bg-[#070d16] text-white rounded-xl font-bold hover:bg-gray-800 transition flex items-center justify-center gap-2 text-sm sm:text-base">
                                        <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                                        カートに入れる
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}"
                                   class="flex-1 h-12 bg-[#070d16] text-white rounded-xl font-bold hover:bg-gray-800 transition flex items-center justify-center text-sm sm:text-base">
                                    ログインして購入
                                </a>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $products->withQueryString()->links() }}
            </div>
        @else
            <div class="bg-gray-50 border border-gray-200 rounded-3xl p-10 text-left">
                <div class="text-5xl mb-4">📦</div>
                <p class="font-bold text-lg mb-2">人気商品がまだ登録されていません</p>
                <p class="text-gray-500 text-sm mb-6">
                    {{-- 管理画面の商品追加・編集で「人気商品としてトップページに表示する」にチェックを入れてください。 --}}
                </p>

                <a href="{{ route('products.all') }}"
                   class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-[#070d16] text-white font-bold">
                    全商品を見る
                </a>
            </div>
        @endif
    </section>

{{-- ShopSwift visual contents --}}
<section class="bg-white py-16 sm:py-20 overflow-hidden">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

      {{-- ShopSwiftのこだわり --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-14">
    <div class="relative overflow-hidden rounded-[2rem] border border-[#e8dccb] bg-[#f8f4ef] shadow-sm">

        {{-- 背景画像 --}}
        <div class="absolute inset-0">
            <img
                src="{{ asset('home/images/commitment-bg.png') }}"
                alt="ShopSwiftのこだわり"
                class="w-full h-full object-cover opacity-55"
            >
            <div class="absolute inset-0 bg-gradient-to-r from-white/95 via-white/85 to-white/60"></div>
        </div>

        <div class="relative grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 p-6 sm:p-8 md:p-12 lg:p-16">

            {{-- 左側テキスト --}}
            <div class="flex flex-col justify-center min-h-[360px] md:min-h-[460px]">
                <p class="inline-flex items-center gap-2 text-sm md:text-base font-bold text-[#75885d] mb-5">
                    <i data-lucide="leaf" class="w-5 h-5"></i>
                    for a better everyday
                </p>

                <h2 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight leading-tight text-[#111827]">
                    ShopSwiftの<br class="sm:hidden">こだわり
                </h2>

                <div class="w-16 h-[2px] bg-[#b8946d] my-7"></div>

                <p class="text-gray-700 leading-loose text-base md:text-lg max-w-xl">
                    毎日の暮らしに、心地よさとやさしさを。<br class="hidden sm:block">
                    使うたびに心が整うような、品質とデザインを大切にしたアイテムをお届けします。
                </p>
            </div>

            {{-- 右側カード --}}
            <div class="bg-white/90 backdrop-blur-md rounded-[2rem] shadow-sm border border-white/80 p-5 sm:p-7 md:p-9">
                <div class="divide-y divide-[#eadfce]">

                    <div class="group flex items-center gap-5 py-5 md:py-7">
                        <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-[#eef1df] flex items-center justify-center shrink-0">
                            <i data-lucide="armchair" class="w-8 h-8 md:w-9 md:h-9 text-[#75885d]"></i>
                        </div>

                        <div class="flex-1">
                            <h3 class="text-xl md:text-2xl font-bold text-[#111827]">
                                長く使えるデザイン
                            </h3>
                            <p class="mt-2 text-sm md:text-base text-gray-600 leading-loose">
                                飽きのこないシンプルなデザインと確かな品質で、長く愛用いただけるアイテムをお届けします。
                            </p>
                        </div>

                        <i data-lucide="chevron-right" class="hidden sm:block w-6 h-6 text-[#b8946d] group-hover:translate-x-1 transition"></i>
                    </div>

                    <div class="group flex items-center gap-5 py-5 md:py-7">
                        <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-[#f3eadb] flex items-center justify-center shrink-0">
                            <i data-lucide="sprout" class="w-8 h-8 md:w-9 md:h-9 text-[#a98244]"></i>
                        </div>

                        <div class="flex-1">
                            <h3 class="text-xl md:text-2xl font-bold text-[#111827]">
                                環境にやさしい選択
                            </h3>
                            <p class="mt-2 text-sm md:text-base text-gray-600 leading-loose">
                                素材選びから梱包まで、環境への配慮を大切に。サステナブルな暮らしを応援します。
                            </p>
                        </div>

                        <i data-lucide="chevron-right" class="hidden sm:block w-6 h-6 text-[#b8946d] group-hover:translate-x-1 transition"></i>
                    </div>

                    <div class="group flex items-center gap-5 py-5 md:py-7">
                        <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-[#f6ded1] flex items-center justify-center shrink-0">
                            <i data-lucide="headphones" class="w-8 h-8 md:w-9 md:h-9 text-[#c27a52]"></i>
                        </div>

                        <div class="flex-1">
                            <h3 class="text-xl md:text-2xl font-bold text-[#111827]">
                                安心のサポート
                            </h3>
                            <p class="mt-2 text-sm md:text-base text-gray-600 leading-loose">
                                ご購入前のご相談からアフターサポートまで、丁寧に対応します。
                            </p>
                        </div>

                        <i data-lucide="chevron-right" class="hidden sm:block w-6 h-6 text-[#b8946d] group-hover:translate-x-1 transition"></i>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>


{{-- はじめての方へ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-14">
    <div class="rounded-[2rem] border border-[#e8dccb] bg-[#f8f1e8] p-6 sm:p-8 md:p-12 lg:p-16 overflow-hidden">

        <div class="mb-10">
            <p class="text-[#c27a52] italic font-bold mb-3">
                Welcome!
            </p>

            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-[#111827]">
                はじめての方へ
            </h2>

            <div class="w-14 h-[2px] bg-[#b8946d] my-6"></div>

            <p class="text-gray-600 leading-loose text-base md:text-lg">
                かんたん3ステップでお買い物が完了します。
            </p>
        </div>

        {{-- PC / tablet --}}
        <div class="hidden md:grid grid-cols-3 gap-6 lg:gap-8 items-start">

            {{-- step 1 --}}
            <div class="relative">
                <div class="relative rounded-[1.75rem] bg-white shadow-sm border border-white overflow-hidden">
                    <div class="relative">
                        <img
                            src="{{ asset('home/images/step-select.png') }}"
                            alt="商品を選ぶ"
                            class="w-full h-52 lg:h-60 object-cover"
                        >

                        <div class="absolute -bottom-7 left-8 w-14 h-14 rounded-full bg-[#75885d] text-white flex items-center justify-center text-xl font-bold shadow-md">
                            1
                        </div>
                    </div>

                    <div class="pt-12 p-7">
                        <div class="w-14 h-14 rounded-full bg-[#eef1df] flex items-center justify-center mb-5">
                            <i data-lucide="search" class="w-7 h-7 text-[#75885d]"></i>
                        </div>

                        <h3 class="text-2xl font-bold text-[#111827]">
                            商品を選ぶ
                        </h3>

                        <p class="mt-4 text-gray-600 leading-loose">
                            豊富なカテゴリから、お好みの商品をお選びください。気になる商品はお気に入りにも追加できます。
                        </p>
                    </div>
                </div>

                <div class="hidden lg:block absolute top-[105px] -right-6 text-[#b8946d] text-3xl">
                    →
                </div>
            </div>

            {{-- step 2 --}}
            <div class="relative">
                <div class="relative rounded-[1.75rem] bg-white shadow-sm border border-white overflow-hidden">
                    <div class="relative">
                        <img
                            src="{{ asset('home/images/step-cart.png') }}"
                            alt="カートに入れる"
                            class="w-full h-52 lg:h-60 object-cover"
                        >

                        <div class="absolute -bottom-7 left-8 w-14 h-14 rounded-full bg-[#c98962] text-white flex items-center justify-center text-xl font-bold shadow-md">
                            2
                        </div>
                    </div>

                    <div class="pt-12 p-7">
                        <div class="w-14 h-14 rounded-full bg-[#f6ded1] flex items-center justify-center mb-5">
                            <i data-lucide="shopping-cart" class="w-7 h-7 text-[#c27a52]"></i>
                        </div>

                        <h3 class="text-2xl font-bold text-[#111827]">
                            カートに入れる
                        </h3>

                        <p class="mt-4 text-gray-600 leading-loose">
                            気になる商品をカートに入れて、数量や合計金額を確認しながら購入手続きへ進めます。
                        </p>
                    </div>
                </div>

                <div class="hidden lg:block absolute top-[105px] -right-6 text-[#b8946d] text-3xl">
                    →
                </div>
            </div>

            {{-- step 3 --}}
            <div>
                <div class="relative rounded-[1.75rem] bg-white shadow-sm border border-white overflow-hidden">
                    <div class="relative">
                        <img
                            src="{{ asset('home/images/step-complete.png') }}"
                            alt="ご注文完了"
                            class="w-full h-52 lg:h-60 object-cover"
                        >

                        <div class="absolute -bottom-7 left-8 w-14 h-14 rounded-full bg-[#d98b65] text-white flex items-center justify-center text-xl font-bold shadow-md">
                            3
                        </div>
                    </div>

                    <div class="pt-12 p-7">
                        <div class="w-14 h-14 rounded-full bg-[#f3eadb] flex items-center justify-center mb-5">
                            <i data-lucide="package-check" class="w-7 h-7 text-[#a98244]"></i>
                        </div>

                        <h3 class="text-2xl font-bold text-[#111827]">
                            ご注文完了
                        </h3>

                        <p class="mt-4 text-gray-600 leading-loose">
                            決済完了後は注文履歴から内容を確認できます。発送状況もわかりやすく表示します。
                        </p>
                    </div>
                </div>
            </div>

        </div>

        {{-- mobile --}}
        <div class="md:hidden space-y-5">

            <div class="grid grid-cols-[96px_1fr] gap-4 rounded-3xl bg-white border border-white shadow-sm p-4">
                <div class="relative">
                    <img
                        src="{{ asset('home/images/step-select.png') }}"
                        alt="商品を選ぶ"
                        class="w-24 h-24 rounded-2xl object-cover"
                    >
                    <div class="absolute -top-2 -left-2 w-8 h-8 rounded-full bg-[#75885d] text-white flex items-center justify-center text-sm font-bold">
                        1
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-[#111827]">
                        商品を選ぶ
                    </h3>
                    <p class="mt-2 text-sm text-gray-600 leading-7">
                        豊富なカテゴリから、お好みの商品をお選びください。
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-[96px_1fr] gap-4 rounded-3xl bg-white border border-white shadow-sm p-4">
                <div class="relative">
                    <img
                        src="{{ asset('home/images/step-cart.png') }}"
                        alt="カートに入れる"
                        class="w-24 h-24 rounded-2xl object-cover"
                    >
                    <div class="absolute -top-2 -left-2 w-8 h-8 rounded-full bg-[#c98962] text-white flex items-center justify-center text-sm font-bold">
                        2
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-[#111827]">
                        カートに入れる
                    </h3>
                    <p class="mt-2 text-sm text-gray-600 leading-7">
                        数量や合計金額を確認しながら購入手続きへ進めます。
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-[96px_1fr] gap-4 rounded-3xl bg-white border border-white shadow-sm p-4">
                <div class="relative">
                    <img
                        src="{{ asset('home/images/step-complete.png') }}"
                        alt="ご注文完了"
                        class="w-24 h-24 rounded-2xl object-cover"
                    >
                    <div class="absolute -top-2 -left-2 w-8 h-8 rounded-full bg-[#d98b65] text-white flex items-center justify-center text-sm font-bold">
                        3
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-[#111827]">
                        ご注文完了
                    </h3>
                    <p class="mt-2 text-sm text-gray-600 leading-7">
                        注文履歴から内容や発送状況を確認できます。
                    </p>
                </div>
            </div>

        </div>

        {{-- support CTA --}}
        <div class="mt-8 md:mt-12 max-w-4xl mx-auto rounded-3xl bg-white/85 border border-[#eadfce] px-5 py-5 md:px-8 md:py-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-[#f3eadb] flex items-center justify-center shrink-0">
                    <i data-lucide="headphones" class="w-6 h-6 text-[#a98244]"></i>
                </div>

                <p class="font-bold text-gray-700 text-center sm:text-left">
                    ご不明な点はいつでもサポートいたします。
                </p>
            </div>

            <a href="{{ route('contact.index') }}"
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-full border border-[#d8c5ad] px-8 py-3 font-bold text-[#111827] hover:bg-[#f8f4ef] transition">
                お問い合わせはこちら
                <i data-lucide="chevron-right" class="w-5 h-5"></i>
            </a>
        </div>

    </div>
</section>

{{-- ShopSwiftでのお買い物：修正版 --}}
<section class="overflow-hidden rounded-[2rem] border border-[#dfe4d2] bg-white my-8">

    <style>
        .ss-benefit-carousel::-webkit-scrollbar {
            display: none;
        }

        .ss-benefit-carousel {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .ss-benefit-card {
            flex: 0 0 calc((100% - 24px) / 2);
            width: calc((100% - 24px) / 2);
        }

        .ss-benefit-card-inner {
            min-height: 380px;
          background-color: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.65);
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.12);
        }

        @media (max-width: 767px) {
            .ss-benefit-card {
                flex: 0 0 100%;
                width: 100%;
            }

            .ss-benefit-card-inner {
                min-height: 320px;
            }
        }
    </style>

    <div class="relative overflow-hidden min-h-[620px]">

        <img
            src="https://images.unsplash.com/photo-1631679706909-1844bbd07221?q=80&w=1992&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            alt="ShopSwiftでのお買い物"
            class="absolute inset-0 w-full h-full object-cover"
        >

       

        <div class="relative z-10 px-5 sm:px-8 lg:px-12 py-12 sm:py-16">
            {{-- 左ボタン：カード外・画像端 --}}
            <button
                type="button"
                id="ssBenefitPrev"
                class="absolute left-4 sm:left-6 lg:left-8 top-1/2 -translate-y-1/2 z-50 w-12 h-12 rounded-full bg-[#f3f4f6]/70 border border-gray-200 shadow flex items-center justify-center hover:bg-white"
                aria-label="前へ"
            >
                <i data-lucide="chevron-left" class="w-6 h-6"></i>
            </button>

            {{-- 右ボタン：カード外・画像端 --}}
            <button
                type="button"
                id="ssBenefitNext"
                class="absolute right-4 sm:right-6 lg:right-8 top-1/2 -translate-y-1/2 z-50 w-12 h-12 rounded-full bg-[#f3f4f6]/70 border border-gray-200 shadow flex items-center justify-center hover:bg-white"
                aria-label="次へ"
            >
                <i data-lucide="chevron-right" class="w-6 h-6"></i>
            </button>

            <div class="text-center mb-10">
                <h2 class="text-3xl sm:text-4xl font-bold mb-4">
                    ShopSwiftでのお買い物
                </h2>

                <p class="text-gray-700 font-bold">
                    安心してご利用いただけるサービスを整えています。
                </p>
            </div>

            <div class="relative max-w-6xl mx-auto">


                {{-- カルーセル --}}
                <div class="sm:px-4 lg:px-16">
                    <div
                        id="ssBenefitCarousel"
                        class="ss-benefit-carousel flex gap-6 overflow-x-auto scroll-smooth snap-x snap-mandatory"
                    >

                        <div class="ss-benefit-card snap-start shrink-0 w-[82vw] sm:w-[560px] lg:w-[620px]">
                            <div class="ss-benefit-card-inner min-h-[380px] bg-white/90 backdrop-blur-sm rounded-3xl p-8 border border-white/80 shadow-sm">
                                <div class="w-16 h-16 rounded-full  flex items-center justify-center mb-8">
                                    <i data-lucide="truck" class="w-8 h-8 text-[#6f7f55]"></i>
                                </div>

                                <h3 class="text-2xl font-bold mb-5 whitespace-normal break-words [writing-mode:horizontal-tb]">
                                    10,000円以上で送料無料 通常¥220
                                </h3>

                                <p class="text-gray-600 leading-8 text-base whitespace-normal break-words [writing-mode:horizontal-tb]">
                                    10,000円以上のご注文で送料が無料に。まとめ買いにも便利です。毎日使うアイテムを気軽にまとめてお選びいただけます。
                                </p>
                            </div>
                        </div>

                        <div class="ss-benefit-card snap-start shrink-0">
                            <div class="ss-benefit-card-inner min-h-[380px] bg-white/90 backdrop-blur-sm rounded-3xl p-8 border border-white/80 shadow-sm">
                                <div class="w-16 h-16 rounded-full  flex items-center justify-center mb-8">
                                    <i data-lucide="refresh-cw" class="w-8 h-8 text-[#6f7f55]"></i>
                                </div>

                                <h3 class="text-2xl font-bold mb-5">
                                    返品・交換のご相談OK
                                </h3>

                                <p class="text-gray-600  leading-8 text-base">
                                    商品到着後の不安にも対応。必要に応じて返品・交換のご相談を承ります。安心してお買い物いただけます。
                                </p>
                            </div>
                        </div>

                        <div class="ss-benefit-card snap-start shrink-0">
                            <div class="ss-benefit-card-inner min-h-[380px] bg-white/90 backdrop-blur-sm rounded-3xl p-8 border border-white/80 shadow-sm">
                                <div class="w-16 h-16 rounded-full  flex items-center justify-center mb-8">
                                    <i data-lucide="lock-keyhole" class="w-8 h-8 text-[#6f7f55]"></i>
                                </div>

                                <h3 class="text-2xl font-bold mb-5">
                                    安全な決済
                                </h3>

                                <p class="text-gray-600  leading-8 text-base">
                                    Stripe決済に対応。カード情報を安全に扱い、スムーズにお支払いできます。購入後は注文履歴から確認できます。
                                </p>
                            </div>
                        </div>

                        <div class="ss-benefit-card snap-start shrink-0">
                            <div class="ss-benefit-card-inner min-h-[380px] bg-white/90 backdrop-blur-sm rounded-3xl p-8 border border-white/80 shadow-sm">
                                <div class="w-16 h-16 rounded-full  flex items-center justify-center mb-8">
                                    <i data-lucide="user-round" class="w-8 h-8 text-[#6f7f55]"></i>
                                </div>

                                <h3 class="text-2xl font-bold mb-5">
                                    会員限定の便利機能
                                </h3>

                                <p class="text-gray-600 leading-8 text-base">
                                    注文履歴・カート・お気に入りなど、会員向けの便利な機能を利用できます。欲しい商品を管理しやすくなります。
                                </p>
                            </div>
                        </div>

                        <div class="ss-benefit-card snap-start shrink-0">
                            <div class="ss-benefit-card-inner min-h-[380px] bg-white/90 backdrop-blur-sm rounded-3xl p-8 border border-white/80 shadow-sm">
                                <div class="w-16 h-16 rounded-full  flex items-center justify-center mb-8">
                                    <i data-lucide="gift" class="w-8 h-8 text-[#6f7f55]"></i>
                                </div>

                                <h3 class="text-2xl font-bold mb-5">
                                    ギフトにも対応
                                </h3>

                                <p class="text-gray-400  leading-8 text-base">
                                    大切な方への贈り物にも選びやすい、暮らしに馴染むアイテムを揃えています。
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 gap-3 max-w-2xl mx-auto">

                <a href="{{ route('products.all') }}"
                   class="inline-flex items-center justify-center gap-2 bg-[#070d16] text-white px-6 py-4 rounded-2xl font-bold hover:bg-gray-800 transition">
                    商品一覧を見る
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </a>

                <a href="{{ route('articles.index') }}"
                   class="inline-flex items-center justify-center gap-2 bg-white/50 border border-gray-200 px-6 py-4 rounded-2xl font-bold hover:bg-white transition">
                    Journalを見る
                    <i data-lucide="newspaper" class="w-5 h-5"></i>
                </a>

            </div>

        </div>

    </div>

</section>
</main>

<footer class="border-t bg-white">
    <div class="max-w-[1500px] mx-auto px-4 sm:px-6 md:px-8 py-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-10 text-sm">
        <div>
            <div class="text-xl font-bold mb-4">ShopSwift</div>
            <p class="text-gray-600 leading-relaxed">
                暮らしを、もっと心地よく。<br>
                シンプルでやさしい毎日をお届けします。
            </p>
        </div>

        <div>
            <div class="font-bold mb-4">ご利用ガイド</div>
            <div class="space-y-2 text-gray-600">
                <div>ご注文方法</div>
                <div>お支払いについて</div>
                <div>送料・配送について</div>
                <div>返品・交換について</div>
            </div>
        </div>

        <div>
            <div class="font-bold mb-4">サービス</div>
            <div class="space-y-2 text-gray-600">
                <div>メルマガ登録</div>
                <div>ギフトラッピング</div>
                <div>お気に入り一覧</div>
            </div>
        </div>
<div>
    <div class="font-bold mb-4">サポート</div>

    <div class="space-y-2 text-gray-600">
        <a href="{{ route('terms') }}" class="block hover:text-black">
            利用規約
        </a>

        <a href="{{ route('privacy') }}" class="block hover:text-black">
            プライバシーポリシー
        </a>

        <a href="{{ route('commercial') }}" class="block hover:text-black">
            特定商取引法に基づく表記
        </a>

        <a href="{{ route('contact.index') }}" class="block hover:text-black">
            お問い合わせ
        </a>
    </div>
</div>

        <div>
            <div class="font-bold mb-4">メルマガ登録</div>
            <p class="text-gray-600 mb-4">新商品やお得な情報をお届けします。</p>
            <div class="flex">
                <input class="border rounded-l-xl px-4 py-3 w-full min-w-0" placeholder="メールアドレスを入力">
                <button class="bg-[#070d16] text-white px-4 rounded-r-xl">›</button>
            </div>
        </div>
    </div>

    <div class="text-center text-sm text-gray-500 pb-8 px-4">
        © 2024 ShopSwift. All rights reserved.
    </div>
</footer>

<nav class="md:hidden fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-gray-200 z-50 grid grid-cols-4 text-xs">
    <a href="{{ route('products.index') }}" class="flex flex-col items-center justify-center gap-1">
        <i data-lucide="home" class="w-5 h-5"></i>
        ホーム
    </a>

    <a href="{{ route('products.all') }}" class="flex flex-col items-center justify-center gap-1">
        <i data-lucide="layout-grid" class="w-5 h-5"></i>
        全商品
    </a>

    <a href="{{ route('contact.index') }}" class="flex flex-col items-center justify-center gap-1">
        <i data-lucide="mail" class="w-5 h-5"></i>
        問合せ
    </a>

    @auth
        <a href="{{ route('mypage') }}" class="flex flex-col items-center justify-center gap-1">
            <i data-lucide="user" class="w-5 h-5"></i>
            マイページ
        </a>
    @else
        <a href="{{ route('login') }}" class="flex flex-col items-center justify-center gap-1">
            <i data-lucide="user" class="w-5 h-5"></i>
            ログイン
        </a>
    @endauth
</nav>

<script>
    lucide.createIcons();

    const userMenuButton = document.getElementById('userMenuButton');
    const userMenu = document.getElementById('userMenu');

    if (userMenuButton && userMenu) {
        userMenuButton.addEventListener('click', function () {
            userMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', function (event) {
            if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });
    }

    const revealElements = document.querySelectorAll('.scroll-reveal');

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
            }
        });
    }, {
        threshold: 0.12
    });

    revealElements.forEach((element) => {
        revealObserver.observe(element);
    });

       document.querySelectorAll('form[action*="/cart"], form[action*="/favorites"]').forEach((form) => {
        form.addEventListener('submit', () => {
            sessionStorage.setItem('scrollPosition', window.scrollY);
        });
    });

    const savedScrollPosition = sessionStorage.getItem('scrollPosition');

    if (savedScrollPosition !== null) {
        window.scrollTo({
            top: parseInt(savedScrollPosition),
            behavior: 'instant'
        });

        sessionStorage.removeItem('scrollPosition');
    }

    const cartToast = document.getElementById('cartToast');

    if (cartToast) {
        setTimeout(() => {
            cartToast.style.opacity = '0';
            cartToast.style.transform = 'translateY(-18px)';
            cartToast.style.transition = '.4s';

            setTimeout(() => {
                cartToast.remove();
            }, 400);
        }, 2500);
    }
    const favoriteActions = document.getElementById('favorite');

    if (favoriteActions) {
        setTimeout(() => {
            favoriteActions.style.opacity = '0';
            favoriteActions.style.transform = 'translateY(-18px)';
            favoriteActions.style.transition = '.4s';

            setTimeout(() => {
                cartToast.remove();
            }, 400);
        }, 2500);
    }



 const ssBenefitCarousel = document.getElementById('ssBenefitCarousel');
    const ssBenefitPrev = document.getElementById('ssBenefitPrev');
    const ssBenefitNext = document.getElementById('ssBenefitNext');

    if (ssBenefitCarousel && ssBenefitPrev && ssBenefitNext) {
        const getCardWidth = () => {
            const card = ssBenefitCarousel.querySelector('.ss-benefit-card');

            if (!card) {
                return 0;
            }

            return card.getBoundingClientRect().width + 24;
        };

        const isAtStart = () => {
            return ssBenefitCarousel.scrollLeft <= 5;
        };

        const isAtEnd = () => {
            return ssBenefitCarousel.scrollLeft + ssBenefitCarousel.clientWidth >= ssBenefitCarousel.scrollWidth - 5;
        };

        ssBenefitNext.addEventListener('click', () => {
            if (isAtEnd()) {
                ssBenefitCarousel.scrollTo({
                    left: 0,
                    behavior: 'smooth',
                });

                return;
            }

            ssBenefitCarousel.scrollBy({
                left: getCardWidth(),
                behavior: 'smooth',
            });
        });

        ssBenefitPrev.addEventListener('click', () => {
            if (isAtStart()) {
                ssBenefitCarousel.scrollTo({
                    left: ssBenefitCarousel.scrollWidth,
                    behavior: 'smooth',
                });

                return;
            }

            ssBenefitCarousel.scrollBy({
                left: -getCardWidth(),
                behavior: 'smooth',
            });
        });
    }

    const siteMenuOpen = document.getElementById('siteMenuOpen');
    const siteMenuClose = document.getElementById('siteMenuClose');
    const siteMobileMenu = document.getElementById('siteMobileMenu');
    const siteMobileOverlay = document.getElementById('siteMobileOverlay');
    const siteMobilePanel = document.getElementById('siteMobilePanel');

    function openSiteMenu() {
        if (!siteMobileMenu || !siteMobileOverlay || !siteMobilePanel) return;

        siteMobileMenu.classList.remove('pointer-events-none');
        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(() => {
            siteMobileOverlay.classList.remove('bg-black/0');
            siteMobileOverlay.classList.add('bg-black/45');

            siteMobilePanel.classList.remove('translate-x-full');
            siteMobilePanel.classList.add('translate-x-0');
        });
    }

    function closeSiteMenu() {
        if (!siteMobileMenu || !siteMobileOverlay || !siteMobilePanel) return;

        siteMobileOverlay.classList.remove('bg-black/45');
        siteMobileOverlay.classList.add('bg-black/0');

        siteMobilePanel.classList.remove('translate-x-0');
        siteMobilePanel.classList.add('translate-x-full');

        setTimeout(() => {
            siteMobileMenu.classList.add('pointer-events-none');
            document.body.classList.remove('overflow-hidden');
        }, 500);
    }

    if (siteMenuOpen) {
        siteMenuOpen.addEventListener('click', openSiteMenu);
    }

    if (siteMenuClose) {
        siteMenuClose.addEventListener('click', closeSiteMenu);
    }

    if (siteMobileOverlay) {
        siteMobileOverlay.addEventListener('click', closeSiteMenu);
    }

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeSiteMenu();
        }
    });

        document.addEventListener('DOMContentLoaded', () => {
        const demoNoticeModal = document.getElementById('demoNoticeModal');
        const demoNoticeClose = document.getElementById('demoNoticeClose');

        if (!demoNoticeModal || !demoNoticeClose) {
            return;
        }

        const hasSeenDemoNotice = localStorage.getItem('shopswift_demo_notice_seen');

        if (!hasSeenDemoNotice) {
            demoNoticeModal.classList.remove('hidden');
            demoNoticeModal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        demoNoticeClose.addEventListener('click', () => {
            localStorage.setItem('shopswift_demo_notice_seen', 'true');

            demoNoticeModal.classList.add('hidden');
            demoNoticeModal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        });
    });

</script>

{{-- Demo Site Notice Modal --}}
<div id="demoNoticeModal"
     class="fixed inset-0 z-[9999] hidden items-center justify-center px-4">

    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

    <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl overflow-hidden">

        <div class="bg-[#070d16] text-white px-6 py-5">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full bg-white/10 flex items-center justify-center">
                    <i data-lucide="info" class="w-6 h-6"></i>
                </div>

                <div>
                    <h2 class="text-xl font-bold">
                        デモサイトについて
                    </h2>

                    <p class="text-sm text-white/60 mt-1">
                        ShopSwift Demo Site
                    </p>
                </div>
            </div>
        </div>

        <div class="px-6 py-7">

            <p class="text-gray-700 leading-8 font-bold">
                このサイトは、Laravel 13で制作したECサイトのデモサイトです。
            </p>

            <div class="mt-5 space-y-3 text-sm text-gray-600 leading-7">
                <p>
                    商品閲覧、会員登録、ログイン、カート、Stripeテスト決済、お問い合わせなど、一通りの機能を確認できます。
                </p>

                <p>
                    Stripe決済はテスト環境のため、実際の請求は発生しません。
                </p>

                <p>
                    デモサイトのため、入力内容や操作内容については自己責任でお願いいたします。
                </p>
            </div>

            <div class="mt-6 rounded-2xl bg-[#f8f4ef] border border-[#eadfd2] px-5 py-4 text-sm text-gray-700 leading-7">
                <div class="font-bold mb-1">
                    テスト決済について
                </div>

                <div>
                    Stripeのテストカード番号 <span class="font-bold">4242 4242 4242 4242</span> で動作確認できます。
                </div>
            </div>

            <button type="button"
                    id="demoNoticeClose"
                    class="mt-7 w-full rounded-2xl bg-[#070d16] text-white py-4 font-bold hover:bg-gray-800 transition">
                理解しました
            </button>

        </div>

    </div>
</div>
</body>
</html>