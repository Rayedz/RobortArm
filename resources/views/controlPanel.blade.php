@extends('layouts.default', ['title' => 'System Control'])
@section('content')
    <div x-data='enginesComponent()'>
        <div class="flex flex-col md:flex-row md:space-x-32 space-y-24 md:space-y-0 items-center justify-center">
            <form class="mt-40 space-y-4 max-w-md sm:max-w-sm w-full">
                <h1 class="mb-2 text-2xl font-bold text-gray-800">Arm Engines</h1>
                <template x-for="engine in engines" :key="engine.id">
                    <div class="flex items-center p-4 space-x-2 bg-white rounded-md">
                        <label :for="`engine${engine.id}`" x-text="`Engine ${engine.id}:`"> </label>
                        <input x-on:change="hasChanged = true" x-model="engine.value" :id="`engine${engine.id}`" min="0"
                            max="180" type="range" class="flex-grow">
                        <p class="w-12 p-1 text-center rounded bg-blue-50" x-text="engine.value"></p>
                    </div>
                </template>

                <div class="space-x-4">
                    <button x-on:click.prevent="update()" :disabled="!hasChanged" class="px-8 py-3 text-white rounded-md"
                        :class="[hasChanged ? 'bg-blue-600' : 'bg-gray-300 cursor-not-allowed']">
                        Save
                    </button>
                    <button x-on:click.prevent="toggleIsOn()" class="w-24 py-3 text-white rounded-md"
                        :class="[isOn ? 'bg-green-600' : 'bg-red-600']" x-text="isOn ? 'On' : 'Off'"></button>
                </div>
            </form>
            <form class="max-w-md sm:max-w-sm w-full">
                <h1 class="mb-2 text-2xl font-bold text-gray-800">Motor Direction</h1>
                <div class="flex flex-col items-center space-y-6 mt-12">
                    <button x-on:click.prevent="updateDirection('forward')"
                        :class="direction === 'forward' && 'ring-4 ring-teal-600'"
                        class="bg-white pb-2 w-24 h-24 text-5xl font-bold focus:outline-none rounded-md shadow-md">
                        &uarr;
                    </button>
                    <div class="flex space-x-6">
                        <button x-on:click.prevent="updateDirection('left')"
                            :class="direction === 'left' && 'ring-4 ring-teal-600'"
                            class="bg-white pb-2 w-24 h-24 text-5xl font-bold focus:outline-none rounded-md shadow-md">
                            &larr;
                        </button>
                        <button x-on:click.prevent="updateDirection('stop')"
                            :class="direction === 'stop' && 'ring-4 ring-teal-600'"
                            class="bg-white pb-1 text-red-500 w-24 h-24 text-3xl font-bold focus:outline-none rounded-full shadow-md">
                            stop
                        </button>
                        <button x-on:click.prevent="updateDirection('right')"
                            :class="direction === 'right' && 'ring-4 ring-teal-600'"
                            class="bg-white pb-2 w-24 h-24 text-5xl font-bold focus:outline-none rounded-md shadow-md">
                            &rarr;
                        </button>
                    </div>
                    <button x-on:click.prevent="updateDirection('backward')"
                        :class="direction === 'backward' && 'ring-4 ring-teal-600'"
                        class="bg-white pb-2 w-24 h-24 text-5xl font-bold focus:outline-none rounded-md shadow-md">
                        &darr;
                    </button>
                </div>
            </form>

        </div>
        <div x-clock :class="!loading && 'hidden'"
            class="fixed inset-0 m-0 bg-gradient-to-r from-blue-200 to-green-100 opacity-90">
            <div class="w-full h-full flex items-center justify-center text-teal-700 border-teal-700">
                <svg class="fill-current stroke-current animate-spin w-12 h-12" version="1.1" id="loader-1"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                    viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
                    <path opacity="0.2" fill="#000"
                        d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946
                                                                        s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634
                                                                        c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z" />
                    <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0
                                                                        C22.32,8.481,24.301,9.057,26.013,10.047z">
                    </path>
                </svg>
            </div>
        </div>
    </div>

    <script>
        const enginesComponent = () => {
            return {
                isOn: {{ $engines[0]->isOn }},
                engines: @json($engines),
                hasChanged: false,
                direction: '{{ $mr->direction }}',
                loading: false,
                getHeader() {
                    return {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                },
                update() {
                    this.loading = true
                    const data = {
                        engines: this.engines
                    }
                    const headers = this.getHeader()
                    fetch("{{ URL::to('/control-panel/update') }}", {
                        headers,
                        body: JSON.stringify(data),
                        method: 'POST'
                    }).then(data => {
                        this.loading = false
                        return data.json()
                    }).then(resp => {
                        this.engines = resp.engines
                        this.hasChanged = false
                    })
                },
                toggleIsOn() {
                    this.loading = true
                    const data = {
                        isOn: !this.isOn
                    }
                    const headers = this.getHeader()
                    fetch("{{ URL::to('/control-panel/toggleOnOff') }}", {
                        headers,
                        body: JSON.stringify(data),
                        method: 'POST'
                    }).then(data => {
                        this.loading = false
                        return data.json()
                    }).then(resp => {
                        this.isOn = resp.engines[0].isOn
                    })
                },
                updateDirection(direction) {
                    this.loading = true
                    const data = {
                        direction
                    }
                    const headers = this.getHeader()
                    fetch("{{ URL::to('/control-panel/updateDirection') }}", {
                        headers,
                        body: JSON.stringify(data),
                        method: 'POST'
                    }).then(data => {
                        this.loading = false
                        return data.json()
                    }).then(resp => {
                        this.direction = resp.mr.direction
                    })
                }
            }
        };
    </script>
@stop
