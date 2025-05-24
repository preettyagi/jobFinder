<x-layout>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">{{-- 
    @if (!empty($jobs))
        @foreach ($jobs as $job)
            <li>{{$job}}</li>
        @endforeach
    @else
    <li>No Jobs available</li>
        
    @endif
    --}}
    @forelse ($jobs as $job)
        <x-job-card :job="$job" />
    @empty
    <li>Not available</li>
    @endforelse
    </div>

    {{-- Pagination Links --}}
    {{$jobs->links()}}
</x-layout>