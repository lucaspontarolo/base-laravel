<template>
  <div>
    <div class="d-flex justify-content-center" v-if="showLoader">
      <div class="container-loader">
        <div class="loader"></div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "loader",

  props: {
    showLoader: {
      required: true
    }
  }
};
</script>

<style scoped>
.container-loader {
  position: absolute;
  width: 100%;
  height: 100%;
  text-align: center;
  background-color: #fcfcfc6b;
  z-index: 99999;
}

.loader {
  position: absolute;
  top: 25%;
  left: 43%;
  width: 80px;
  height: 80px;
  border-radius: 50%;
  border: 3px solid transparent;
  border-top-color: #4e73df;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

.loader:before {
  content: "";
  position: absolute;
  top: 5px;
  left: 5px;
  right: 5px;
  bottom: 5px;
  border-radius: 50%;
  border: 3px solid transparent;
  border-top-color: #6f42c1;
  -webkit-animation: spin 3s linear infinite;
  animation: spin 3s linear infinite;
}

.loader:after {
  content: "";
  position: absolute;
  top: 15px;
  left: 15px;
  right: 15px;
  bottom: 15px;
  border-radius: 50%;
  border: 3px solid transparent;
  border-top-color: #36b9cc;
  -webkit-animation: spin 1.5s linear infinite;
  animation: spin 1.5s linear infinite;
}

@-webkit-keyframes spin {
  0% {
    -webkit-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

@keyframes spin {
  0% {
    -webkit-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
</style>
