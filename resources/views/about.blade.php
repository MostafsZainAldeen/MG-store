@extends('layouts.app')

@section('title', __('store.about.title'))

@section('content')
    <section class="py-16">
        <div class="mg-container max-w-4xl">
            <h1 class="font-display text-5xl text-white">{{ __('store.about.title') }}</h1>
            <div class="mt-10 space-y-8 text-base leading-relaxed text-white/75">
                <div>
                    <h2 class="font-display text-3xl text-[var(--color-mg-gold)]">{{ __('store.about.story') }}</h2>
                    <p class="mt-4">
                        {{ app()->getLocale() === 'ar'
                            ? 'نؤمن أن كل قطعة تختارها — ساعة، شنطة، محفظة، أو إكسسوار — تعبّر عن ذوقك وثقتك بنفسك والتفاصيل التي تميّزك.'
                            : 'We believe every piece you choose — a watch, a bag, a wallet, or an accessory — is a statement of taste, confidence, and the details that define you.' }}
                    </p>
                </div>
                <div>
                    <h2 class="font-display text-3xl text-[var(--color-mg-gold)]">{{ __('store.about.mission') }}</h2>
                    <p class="mt-4">
                        {{ app()->getLocale() === 'ar'
                            ? 'نوفر لك تشكيلة واسعة من الساعات والشنط والإكسسوارات والمحافظ من ماركات عالمية، مع تجربة تسوق فاخرة وخدمة تليق بتوقعاتك.'
                            : 'We bring together watches, bags, accessories, and leather goods from renowned brands — with a refined experience and service worthy of your expectations.' }}
                    </p>
                </div>
                <div>
                    <h2 class="font-display text-3xl text-[var(--color-mg-gold)]">{{ __('store.about.trust') }}</h2>
                    <p class="mt-4">
                        {{ app()->getLocale() === 'ar'
                            ? 'الأصالة، الشفافية، والالتزام بأعلى معايير الجودة في كل طلب.'
                            : 'Authenticity, transparency, and uncompromising quality in every order.' }}
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
