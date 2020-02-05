<script>
import SortIcon from "@/components/data-list/SortIcon.js";

export default {
  template: "#data-list",

  mixins: [],

  props: {
    dataSource: {
      type: String
    },

    urlCreate: {
      type: String,
      default() {
        return null;
      }
    },

    labelCreate: {
      type: String,
      default() {
        return "Cadastrar novo";
      }
    },

    deleteTitle: {
      type: String,
      default() {
        return "Tem certeza que deseja apagar este registro?";
      }
    },

    deleteMessage: {
      type: String,
      default() {
        return "Tem certeza que deseja apagar este registro?";
      }
    }
  },

  watch: {
    query: _.debounce(function(text) {
      this.currentPage = 1;
    }, 300),

    fetch_url: _.debounce(function(text) {
      this.fetchData();
    }, 200)
  },

  computed: {
    queryFilters() {
      let query_filters = "";
      for (var filterName in this.filters) {
        if (this.filters.hasOwnProperty(filterName)) {
          query_filters += "&" + filterName + "=" + this.filters[filterName];
        }
      }
      return query_filters;
    },

    fetch_url() {
      let query_params = "";
      query_params = "?query=" + this.query;
      query_params += "&field=" + this.field;
      query_params += "&order=" + this.sortIcon.order;

      _.forEach(this.filterType, function(value, key) {
        if (
          value !== "undefined" &&
          value !== null &&
          typeof value === "object"
        ) {
          query_params += "&" + key + "=" + value.id;
        } else if (value !== "undefined" && value !== null) {
          query_params += "&" + key + "=" + value;
        }
      });

      if (this.currentPage != 1) {
        query_params += "&page=" + this.currentPage;
      }

      query_params += this.queryFilters;

      const url = this.dataSource + query_params;
      return url;
    },

    emptyResult() {
      return typeof this.items == "undefined" || this.items.length == 0;
    },

    enabledNextPageButton() {
      return this.currentPage < this.totalPages;
    },

    enabledPrevPageButton() {
      return this.currentPage > 1;
    },

    shouldShowPagination() {
      return this.totalPages > 1;
    }
  },

  data: function() {
    return {
      items: [],
      filters: {
        perPage: 10
      },
      query: "",
      field: "",
      filterType: {},
      isLoading: true,
      sortIcon: new SortIcon(),
      totalPages: 1,
      currentPage: 1,
      itemsPerPage: 10,
      paginationButtons: [],
      count: {
        totalRegistries: 0
      }
    };
  },

  mounted() {
    this.sortIcon.setArrow();
    this.listenFilters();
    this.fetchData().then(() => {
      if (!!window.__FILTER__) {
        this.filterType = window.__FILTER__;
      }
    });

    this.listenLoadingEvents();
  },

  methods: {
    getRef(ref) {
      return this.$refs[ref];
    },

    orderBy(field, event) {
      this.field = field;
      this.sortIcon.change(event);
    },

    setPagination(fetched_data) {
      if (typeof fetched_data !== "undefined") {
        this.totalPages = fetched_data.last_page;
        this.currentPage = fetched_data.current_page;
        this.itemsPerPage = fetched_data.per_page;
      }
    },

    async fetchData() {
      this.$root.$emit("start-loading");
      const response = await axios.get(this.fetch_url);

      this.items = response.data.data;
      this.setPagination(response.data.meta);
      this.definePaginationButtons();
      this.updateTotal(response.data);
      this.$root.$emit("stop-loading");
      this.$nextTick().then(function() {
        $('[data-toggle="popover"]').popover();
      });
    },

    listenFilters() {
      this.$on("setFilter", payload => {
        this.setFilter(payload.urlKey, payload.value);
      });
    },

    fetchPrevPage() {
      if (this.enabledPrevPageButton) {
        this.currentPage = this.currentPage - 1;
        this.fetchData();
      }
    },

    fetchNextPage() {
      if (this.enabledNextPageButton) {
        this.currentPage = this.currentPage + 1;
        this.fetchData();
      }
    },

    setFilter(name, value) {
      if (value) {
        this.$set(this.filters, name, value);
      } else {
        delete this.filters[name];
        this.filters = _.assign({}, this.filters);
      }
    },

    definePaginationButtons() {
      const totalPages = this.totalPages;
      let startPage = this.currentPage - 2;
      let endPage = this.currentPage + 2;
      let buttons = [];

      if (startPage <= 0) {
        endPage -= startPage - 1;
        startPage = 1;
      }

      if (endPage > totalPages) endPage = totalPages;

      if (startPage > 1) {
        buttons.push({ disabled: false, page: 1, text: "1" });
        buttons.push({ disabled: true, page: 0, text: "..." });
      }

      for (let i = startPage; i <= endPage; i++) {
        const active = i == this.currentPage;
        buttons.push({ disabled: false, page: i, text: i, active: active });
      }

      if (endPage < totalPages) {
        buttons.push({ disabled: true, page: 0, text: "..." });
        buttons.push({ disabled: false, page: totalPages, text: totalPages });
      }

      this.paginationButtons = buttons;
    },

    changePage(page) {
      this.currentPage = page;
      this.fetchData();
    },

    handleDelete(link) {
      axios.delete(link).then(response => {
        const status = response.data;
        this.$swal({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 3000,
          type: status.type,
          title: status.message
        });
        this.fetchData();
      }).catch(error => {
        let message = "Não foi possível remover o registro selecionado.";
        if (error.response.status === 403) {
          message = "Você não possuí permissões para remover este registro.";
        }

        this.$swal({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 3000,
          type: "error",
          title: message
        });
    });
    },

    confirmDelete(link, title = undefined, message = undefined) {
      if (title == undefined) {
        title = this.deleteTitle;
      }

      if (message == undefined) {
        message = this.deleteMessage;
      }

      this.$swal({
        title: "Atenção!",
        html: "Deseja realmente remover este registro?",
        type: "question",
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: "Sim",
        cancelButtonText: "Fechar"
      }).then(result => {
        if (result.value) {
          this.handleDelete(link);
        }
      });
    },

    updateTotal(data) {
      this.count.totalRegistries = data.meta.total;
    },

    listenLoadingEvents() {
      this.$root.$on("start-loading", () => {
        this.isLoading = true;
      });

      this.$root.$on("stop-loading", () => {
        this.isLoading = false;
      });
    }
  }
};
</script>
