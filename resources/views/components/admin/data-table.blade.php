@props([
    'headers' => [],
    'sortable' => false,
    'selectable' => false,
    'striped' => false,
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl border border-slate-200 overflow-hidden']) }}>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            @if(count($headers) > 0)
                <thead class="bg-slate-50">
                    <tr>
                        @if($selectable)
                            <th scope="col" class="w-12 px-4 py-3">
                                <input type="checkbox"
                                       x-data
                                       @change="$dispatch('select-all', $event.target.checked)"
                                       class="w-4 h-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                            </th>
                        @endif

                        @foreach($headers as $key => $header)
                            @php
                                $headerText = is_array($header) ? ($header['label'] ?? $header) : $header;
                                $headerSortable = is_array($header) ? ($header['sortable'] ?? false) : false;
                                $headerClass = is_array($header) ? ($header['class'] ?? '') : '';
                                $headerWidth = is_array($header) ? ($header['width'] ?? '') : '';
                            @endphp
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider {{ $headerClass }}"
                                @if($headerWidth) style="width: {{ $headerWidth }}" @endif>
                                @if($headerSortable && $sortable)
                                    <button type="button" class="group inline-flex items-center gap-1 hover:text-slate-900">
                                        {{ $headerText }}
                                        <span class="text-slate-400 group-hover:text-slate-600">
                                            <i class="fas fa-sort text-xs"></i>
                                        </span>
                                    </button>
                                @else
                                    {{ $headerText }}
                                @endif
                            </th>
                        @endforeach
                    </tr>
                </thead>
            @endif

            <tbody class="bg-white divide-y divide-slate-200 {{ $striped ? '[&>tr:nth-child(odd)]:bg-slate-50' : '' }}">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    @if(isset($footer))
        <div class="px-4 py-3 border-t border-slate-200 bg-slate-50">
            {{ $footer }}
        </div>
    @endif
</div>
