@extends('layouts.default', ['title' => 'System Control'])
@section('content')
<div x-data='enginesComponent()' class="flex flex-col items-center justify-center bg-gray-100">
	<form class="mt-40 space-y-4">
		<h1 class="mb-2 text-2xl font-bold text-gray-800">Robot Arm System</h1>
		<template x-for="engine in engines" :key="engine.id">
			<div class="flex items-center p-4 space-x-2 bg-white rounded-md">
				<label :for="`engine${engine.id}`" x-text="`Engine ${engine.id}:`"> </label>
				<input x-on:change="hasChanged = true" x-model="engine.value" :id="`engine${engine.id}`" min="0" max="180" type="range">
				<p class="w-12 p-1 text-center rounded bg-blue-50" x-text="engine.value"></p>
			</div>
		</template>

		<div class="space-x-4">
			<button x-on:click.prevent="update()" :disabled="!hasChanged" class="px-8 py-3 text-white rounded-md" :class="[hasChanged ? 'bg-blue-600' : 'bg-gray-300 cursor-not-allowed']">
				Save
			</button>
			<button x-on:click.prevent="" class="w-24 py-3 text-white rounded-md" :class="[isOn ? 'bg-green-600' : 'bg-red-600']"
				x-text="isOn ? 'On' : 'Off'" x-on:click="toggleIsOn()"></button>
		</div>
	</form>
</div>

<script>
    const enginesComponent = () => {
        return {
            isOn: {{ $engines[0]->isOn }},
            engines: @json($engines),
            hasChanged: false,
            getHeader() {
                return {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            },
            update() {
                const data = {
                    engines: this.engines
                }
                const headers = this.getHeader()
                fetch("{{ URL::to('/system-control/update') }}", {
                    headers,
                    body: JSON.stringify(data),
                    method: 'POST'
                }).then(data => {
                    return data.json()
                }).then(resp => {
                    this.engines = resp.engines
                    this.hasChanged = false
                })
            },
            toggleIsOn() {
                const data = {
                    isOn: !this.isOn
                }
                const headers = this.getHeader()
                fetch("{{ URL::to('/system-control/toggleOnOff') }}", {
                    headers,
                    body: JSON.stringify(data),
                    method: 'POST'
                }).then(data => {
                    return data.json()
                }).then(resp => {
                    this.isOn = resp.engines[0].isOn
                })
            }
        }
    };
</script>
@stop
