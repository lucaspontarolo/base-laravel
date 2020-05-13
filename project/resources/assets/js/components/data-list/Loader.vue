<template>
  <div>
    <div
      class="d-flex justify-content-center align-items-center container-loader"
      v-if="showLoader">
      <div class="spinner"></div>
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
.spinner {
  border: 5px solid rgba(0, 0, 0, 0.1);
  border-left-color: #6777ef;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  animation: spin 1s linear infinite;
}

.container-loader {
  position: absolute;
  width: 100%;
  height: 100%;
  background-color: #fcfcfc6b;
  z-index: 99999;
}

@keyframes {
  to {
    transform: rotate(360deg);
  }
}
</style>
