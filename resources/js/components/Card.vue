<template>
  <div 
  class="card mb-3">

    <div class="post-cover">
      <img :src="cover" :alt="title">
    </div>

    <div class="card-body">
      
      <div class="d-flex justify-content-between">
        <h5 class="card-title">{{ title }}</h5>
        <span class="badge badge-success custom-badge">{{ category }}</span>
      </div>

      <i>{{ date }}</i>
      <p class="card-text">{{ truncateText }}</p>
      <router-link class="btn btn-primary" :to="{name: 'postDetail', params:{slug}}">Vedi post</router-link>

    </div>

  </div>
</template>

<script>
export default {
  name: 'Card',
  props: ['title', 'category', 'date', 'content', 'slug', 'cover'],
  data(){
    return{
      maxLengthText:150
    }
  },
  computed:{
    truncateText(){
      let text = this.content;
      if(text.length > this.maxLengthText){
        text = text.substr(0, this.maxLengthText) + '...';
      }
      return text;
    }
  }
}
</script>

<style lang="scss" scoped>
.custom-badge{
  display: inline-block;
  height: 2rem;
  line-height: 2rem;
}
.post-cover{
  width: 300px;
  img{
    width: 100%;
  }
}
</style>