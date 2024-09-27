@extends('layouts.main')

@section('content')
    <div id="Top-navbar" class="flex items-center justify-between px-5 pt-5 w-full">
        <a href="" onclick="window.history.back(); return false;">
            <div class="size-[44px] flex shrink-0">
                <img src="{{asset("assets/images/icons/arrow-left.svg")}}" alt="icon" />
            </div>
        </a>
        <p class="text-lg leading-[27px] font-semibold">Choose Brand</p>
        <button class="size-[44px] flex shrink-0">
            <img src="{{asset("assets/images/icons/more.svg")}}" alt="icon" />
        </button>
    </div>
    <a id="promo" href="#" class="px-5 mt-[30px]">
        <div class="w-full aspect-[353/100] flex shrink-0 overflow-hidden rounded-2xl">
            <img src="{{asset("assets/images/backgrounds/promo.png")}}" class="w-full h-full object-cover" alt="promo" />
        </div>
    </a>
    <section id="Brand" class="flex flex-col gap-[30px] mt-[30px] px-5">
        <div id="{{$category->slug}}-brands" class="grid grid-cols-2 gap-5">
            @forelse ($category->brand_categories as $brand)
                <a href="{{route('home.brand', $brand->brand->slug)}}"
                    class="flex p-[33px] border border-[#EDEEF0] rounded-2xl overflow-hidden items-center justify-center transition-all duration-300 hover:ring-2 hover:ring-[#FCCF2F]">
                    <div class="h-full w-[100px] flex shrink-0">
                        <img src="{{Storage::url($brand->brand->logo)}}" alt="{{$brand->brand->name}}" class="size-full" />
                    </div>
                </a>
            @empty
                <p>Belum ada brand dalam kategori {{$category->name}}</p>
            @endforelse
           
        </div>
    </section>
@endsection