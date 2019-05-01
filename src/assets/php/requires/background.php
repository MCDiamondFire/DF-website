<div id="backgroundWrapper">
  <div id="background">
  </div>
  <div id="backgroundTint"></div>
</div>

<style>
  #backgroundWrapper {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 100vw;
    z-index: -1;
  }
  #background {
    position: absolute;
    height: 100%;
    width: 100%;
    z-index: -1;
    filter: blur(3px);
    transform: translateX(-50%);
    margin-left: 50%;
    background: url(/assets/images/backgrounds/1.jpg);
    background-repeat: no-repeat;
    background-size: cover;
  }

  #backgroundTint {
    position: absolute;
    height: 100%;
    width: 100%;
    z-index: 0;
    background-color: rgba(255, 255, 255, 0.75);
  }
</style>
