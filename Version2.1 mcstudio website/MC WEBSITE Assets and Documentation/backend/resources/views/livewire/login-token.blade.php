
<style>
  body {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
.center {
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background: var(--color-secondary);
}
.wave {
  width: 5px;
  height: 100px;
  background: linear-gradient(45deg, var(--color-primary), var(--color-pending));
  margin: 10px;
  animation: wave 1s linear infinite;
  border-radius: 20px;
}
.wave:nth-child(2) {
  animation-delay: 0.1s;
}
.wave:nth-child(3) {
  animation-delay: 0.2s;
}
.wave:nth-child(4) {
  animation-delay: 0.3s;
}
.wave:nth-child(5) {
  animation-delay: 0.4s;
}
.wave:nth-child(6) {
  animation-delay: 0.5s;
}
.wave:nth-child(7) {
  animation-delay: 0.6s;
}
.wave:nth-child(8) {
  animation-delay: 0.7s;
}
.wave:nth-child(9) {
  animation-delay: 0.8s;
}
.wave:nth-child(10) {
  animation-delay: 0.9s;
}

@keyframes wave {
  0% {
    transform: scale(0);
  }
  50% {
    transform: scale(1);
  }
  100% {
    transform: scale(0);
  }
}
</style>

{{-- <div class="flex justify-center items-center relative">
  <div class="absolute inset-0 bg-login" style="background: background-image: url('/public/images/bg-2.jpeg') no-repeat;"></div>
  <span class="relative flex h-3 w-3">
    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
    <span class="relative inline-flex rounded-full h-3 w-3 bg-sky-500"></span>
  </span>
</div> --}}
<div class="center" wire:init="authenticate">
  <div class="wave"></div>
  <div class="wave"></div>
  <div class="wave"></div>
  <div class="wave"></div>
  <div class="wave"></div>
  <div class="wave"></div>
  <div class="wave"></div>
  <div class="wave"></div>
  <div class="wave"></div>
  <div class="wave"></div>
</div>