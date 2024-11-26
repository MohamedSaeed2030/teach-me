<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    {{-- <div>
        <iframe src="https://player.vimeo.com/video/{{$getState()}}"></iframe>

    </div> --}}
    {{-- {{dd($getState());}} --}}
    {{-- <div class="relative pt-[56.25%]" >
        <iframe src="https://player.vimeo.com/video/{{$getState()}}"
        frameborder="0"
        allow="autoplay; fullscreen; picture-in-picture; clipboard-write"
        title="فنجان"
        class="absolute top-0 left-0 w-full h-full"
        >

    </iframe>
    </div> --}}




    <div style="padding:100% 0 0 0;position:relative;">
        <iframe src="https://player.vimeo.com/video/{{$getState()}}"
        frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write"
        style="position:absolute;top:0;left:0;width:100%;height:100%;"
        title="فنجان"></iframe>
    </div>

    <script src="https://player.vimeo.com/api/player.js"></script>

</x-dynamic-component>

    @script
    <script>
        let iframe =document.querySelector('iframe');
        let player = new Vimeo.Player(iframe);

        player.on('ended' ,(data) =>{
            $wire.dispatch('episode-ended',{
            episode:'{{$getRecord()->id}}'
            });
        });

    </script>
    @endscript
