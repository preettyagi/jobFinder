<x-layout>
    <div class="bg-white rounded-lg shadow-md w-full md:max-w-xl mx-auto mt-12 p-8 py-12">
        <h2 class="text-4xl text-center font-bold mb-4">Register</h2>
        <form action="{{route('register.store')}}" method="POST">
            @csrf
            <x-inputs.text id="name" name="name" label="Name" placeholder="Full Name"/>
            <x-inputs.text id="email" name="email" label="Email" type="email" placeholder="Email Address"/>
            <x-inputs.text id="password" name="password" label="Password" type="password" placeholder="Enter Password"/>
            <x-inputs.text id="password_confirmation" name="password_confirmation" label="Confirm Password" type="password" placeholder="Re-Enter Password"/>
            <button type="submit" class="w-full bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded focus:outline-none">
                Register
            </button>
            <p class="mt-4">
                Already have an account? <a href="{{route('login')}}" class="text-purple-500">Click here</a>
            </p>
        </form>
    </div>
</x-layout>
