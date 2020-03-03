<template>
    <div>
      <div v-if="loading" class="loader">
          <div class="inner one"></div>
          <div class="inner two"></div>
          <div class="inner three"></div>
        </div>

      <form @submit.prevent="pageSpeed" class="w-full pl-10 max-w-sm md:pl-0">
      <div class="flemd:flex md:items-center mb-6">
        <div class="md:w-1/3">
          <label class="leading-normal text-base md:text-xl mb-8 text-center md:text-left" for="url">
            Odkaz 
          </label>
        </div>
        <div class="md:w-2/3">
          <input v-model="url" v-bind:class="{ 'border-red-500': errors.url }"  id="url" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" type="url" placeholder="https://vaseStranka.cz" required>
          <p
                  v-if="errors.url"
                  class="text-red-500 text-xs italic"
                >{{errors.url}}</p>
        </div>
      </div>
      <div class="md:flex md:items-center">
        <div class="md:w-1/3"></div>
        <div class="md:w-2/3">
          <button class="shadow bg-purple-800 hover:bg-purple-600 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" :disabled="loading" type="submit">
            Zkontrolovat
          </button>
        </div>
      </div>
    </form>

      <div>
          <div class="p-4 md:p-0 md:pt-4" v-if="audits">
              <div class="flex justify-between  w-full md:w-2/6">
              <div>Status skenované stránky</div>
              <div v-if="status" class="pl-2">{{status}}</div>
             </div>
              <!-- <div>
             Status kód
             <div>{{cond(audits['http-status-code'].score)}}</div>
             </div> -->
              <div class="flex justify-between  w-full md:w-2/6">
             <div>Stránka podporuje Gzip</div>
             <div class="pl-2">{{cond(audits['uses-text-compression'].numericValue)}}</div>
             </div>
             <div class="w-full">{{audits['uses-text-compression'].displayValue}}</div>
              <div class="flex justify-between  w-full md:w-2/6">
               <div>Stránka podporuje webp/image</div>
               <div class="pl-2">{{cond(audits['uses-webp-images'].numericValue)}}</div>
             </div> 
               <div class="w-full">{{audits['uses-webp-images'].displayValue}}</div>
            <div class="flex justify-between  w-full md:w-2/6">          
               <div>Stránka podporuje http2/0</div>
               <div class="pl-2">{{cond(audits['is-on-https'].score)}}</div>
            </div>
             <div class="flex justify-between  w-full md:w-2/6">
               <div>Stránka obsahuje meta description??</div>
               <div class="pl-2">{{cond(audits['meta-description'].score)}}</div>
             </div>
             <div class="flex justify-between  w-full md:w-2/6">
               <div>Lze zahrnout do výsledků vyhledávání??</div>
               <div class="pl-2">{{cond(audits['is-crawlable'].score)}}</div>
             </div>
             <div class="flex justify-between  w-full md:w-2/6">
               <div>Robot.txt</div>
               <div class="pl-2">{{cond(audits['robots-txt'].score)}}</div>
             </div>
             <div class="flex justify-between  w-full md:w-2/6">
               <div>Všechny obrázky mají vyplněný alt tag.</div>
               <div class="pl-2">{{cond(audits['image-alt'].score)}}</div>
             </div>
          </div>
      </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
      url: "",
      loading: false,
      errors: "",
      status: "",
      audits: "",
      status: ""
    };
  },
  methods: {
    pageSpeed() {
      this.status = "";
      this.audits = "";
      this.loading = true;
      this.errors = [];
      axios
        .post("api/pagespeed", {
          url: this.url
        })
        .then(res => {
          this.loading = false;
          res.data.audits ? (            
             this.audits = res.data.audits,
             this.status = this.audits["network-requests"].details.items[0].statusCode
          )
            : (
              this.errors.url = 'Stránka neexistuje',
              this.url = ""
            );
        })
        .catch(error => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          }
          this.loading = false;
        });
    },
    cond(state) {
      return state ? "Ano" : "Ne";
    }
  }
};
</script>
