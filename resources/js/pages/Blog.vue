<template>
  <div>
    <h1>Il mio blog</h1>

    <!-- loading -->
    <div 
    v-if="!loaded"
    class="text-center mt-5">
      <div class="lds-dual-ring"></div>
    </div>


    <!-- contenuto blog -->
    <div
    v-if="loaded"
    >

      <div 
      v-for="post in posts"
      :key="'p'+post.id"
      class="card mb-3">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <h5 class="card-title">{{ post.title }}</h5>
            <span class="badge badge-success custom-badge">{{ post.category }}</span>
          </div>
          <i>{{ formatDate(post.date) }}</i>
          <p class="card-text">{{ post.content }}</p>
          <a href="#" class="btn btn-primary">Vai</a>
        </div>
      </div>

      <!-- paginazione -->
      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <li 
          :class="{'disabled': pagination.current === 1}"
          class="page-item">
            <button 
            @click="getPosts(pagination.current - 1)"
            class="page-link" href="#">&laquo;</button>
          </li>

          <li 
          v-for="i in pagination.last"
          :key="'p'+i"
          :class="{'active' : pagination.current === i}"
          class="page-item">
            <button 
            @click="getPosts(i)"
            class="page-link" href="#">{{ i }}</button>
          </li>

          <li 
          :class="{'disabled': pagination.current === pagination.last}"
          class="page-item">
            <button 
            @click="getPosts(pagination.current + 1)"
            class="page-link" href="#">&raquo;</button>
          </li>
        </ul>
      </nav>
      <!-- /paginazione -->

    </div>
    <!-- /contenuto blog -->


  </div>
</template>

<script>

import axios from 'axios';

export default {
  name: 'Blog',
  data(){
    return{
      posts: [],
      pagination: {},
      loaded: false
    }
  },
  methods:{
    getPosts(page = 1){ 
      this.loaded =false;
      axios.get('http://127.0.0.1:8000/api/posts', {
        params:{
          page: page
        }
      })
        .then(res => {
          console.log(res.data.data);
          this.posts = res.data.data;
          this.pagination = {
            current: res.data.current_page,
            last: res.data.last_page,
          }
          this.loaded = true;
        })
        .catch(err => {
          console.log(err);
        })
    },

    formatDate(date){
      let d = new Date(date);
      let dy = d.getDate();
      let m = d.getMonth() + 1;
      let y = d.getFullYear();

      if(dy < 10) dy = '0' + dy;
      if(m < 10) m = '0' + m;

      return `${dy}/${m}/${y}`;

    }

  },
  created(){
    this.getPosts();
  }
}
</script>

<style lang="scss" scoped>
.custom-badge{
  display: inline-block;
  height: 2rem;
  line-height: 2rem;
}

.lds-dual-ring {
  display: inline-block;
  width: 80px;
  height: 80px;
}
.lds-dual-ring:after {
  content: " ";
  display: block;
  width: 64px;
  height: 64px;
  margin: 8px;
  border-radius: 50%;
  border: 6px solid cornflowerblue;
  border-color: cornflowerblue transparent cornflowerblue transparent;
  animation: lds-dual-ring 1.2s linear infinite;
}
@keyframes lds-dual-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}


</style>