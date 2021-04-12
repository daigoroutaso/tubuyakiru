<template>
    <div>
        <vue-poll v-bind="options" @addvote="addVote"/>
    </div>
</template>

<script> 
    
    import VuePoll from 'vue-poll'
    
    export default {     
        props : ['content'],   
        data() {

            let contents = [];
            let answers = [];
 
            for (let i = 0; i < this.content.pais.length ; i += 2) contents.push(this.content.pais.substring(i,i + 2))
            if(this.content.tumo !== ''){
                contents.push(this.content.tumo)
            }
            contents = Array.from(new Set(contents))

            contents = contents.map(function(pai){
                return pai.replace('1z','東').
                           replace('2z','南').
                           replace('3z','西').
                           replace('4z','北').
                           replace('5z','白').
                           replace('6z','發').
                           replace('7z','中')
            })

            contents.forEach((pai,index) => {
                let answer = {value: index, text: pai, votes: this.content['vote_' + index.toString()]};
                answers.push(answer);
            })

            return {
                options: {
                    question: '　　　　　　　何切る？　　　　　　　',
                    answers: answers
                }
            }
        },
        components: {
            VuePoll
        },
        methods: {
            addVote(obj){                	
                toastr.info('投票しました！');
                
                //サーバーへ送信
                axios
                .post('/poll',{
                    select_idx: obj.value,
                    page_id : this.content.id                        
                })
                .then(response => {
                    console.log(response.data)
                })
            }
        }
    }
</script>

<style>
.vue-poll .qst{
    color: #f8f9fa !important;
}
.vue-poll .ans-cnt .ans-no-vote{
    border: 1px solid #f8f9fa !important;
}
.vue-poll .ans-cnt .ans-no-vote .txt {
    color: #f8f9fa !important;
}
</style>
