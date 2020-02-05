<template>
  <div v-if="active" class="breadcrumb-item active" aria-current="page">
    <slot>Breadcrumb Item</slot>
  </div>
  <div v-else class="breadcrumb-item">
    <a :href="href">
      <slot>Breadcrumb Item</slot>
    </a>
  </div>
</template>

<script>
export default {
  name: "breadcrumb-item",

  props: {
    href: {
      required: false,
      type: String,
      default: () => {
        return "#";
      }
    },
    active: {
      required: false,
      type: Boolean,
      default: () => {
        return false;
      }
    }
  }
};
</script>
