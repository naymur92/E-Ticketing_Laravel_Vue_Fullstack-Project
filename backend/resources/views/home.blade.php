<x-guest-layout>
  <front-layout :auth='{{ json_encode(auth()->user() ?? []) }}'></front-layout>
</x-guest-layout>
