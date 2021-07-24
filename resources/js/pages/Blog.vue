<template>
  <div>
    <h1>Il mio blog</h1>

    <!-- loading -->
    <div v-if="!loaded">
      <Loader />
    </div>



    <!-- contenuto blog -->
    <div
    v-if="loaded"
    >

      <Card
      v-for="post in posts"
      :key="'p'+post.id"
      :title="post.title"
      :category="post.category"
      :cover="post.cover"
      :date="FormatDate.format(post.date)"
      :content="post.content"
      :slug="post.slug"
      />

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
import Loader from '../components/Loader.vue';
import Card from '../components/Card.vue';
import FormatDate from '../classes/FormatDate';

export default {
  name: 'Blog',
  components:{
    Loader,
    Card
  },
  data(){
    return{
      posts: [],
      pagination: {},
      loaded: false,
      FormatDate
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
/* 
    formatDate(date){
      let d = new Date(date);
      let dy = d.getDate();
      let m = d.getMonth() + 1;
      let y = d.getFullYear();

      if(dy < 10) dy = '0' + dy;
      if(m < 10) m = '0' + m;

      return `${dy}/${m}/${y}`;

    }
 */
  },
  created(){
    this.getPosts();
  }
}
</script>

<style lang="scss" scoped>


</style>