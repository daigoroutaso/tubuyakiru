<template>
    <form action="/create" method="POST">
        <input type="hidden" name="_token" v-bind:value="csrf">

        <!-- 牌記号入力テキストフォーム -->
        <div class="row justify-content-center px-4">
            <input id="input-pais" type="text" name="input-pais" :value="pai_text" @input="onPaiInput"　class="form-control pai-input rounded-pill" maxlength="34" placeholder="14牌になるように牌記号を入力しましょう">
        </div>

        <!-- 牌姿のプレビュー表示 -->
        <div class="row justify-content-center px-4">
            <div class="pai-preview-container">
                <div v-for="pai in pais" :key="pai.no" class="pai-item">
                    <img :src="pai.img_path" alt="">
                </div>
                <div v-if="tumo" class="pai-item ml-2">
                    <img :src="tumo" alt="">
                    <p>ツモ</p>
                </div>
                <div v-if="dora" class="pai-item ml-2">
                    <img :src="dora" alt="">
                    <p>ドラ</p>
                </div>
            </div>
        </div>

        <!-- アラートメッセージ -->
        <div class="row justify-content-center">
            <div class="alert" v-bind:class="[hasError ? alertWarning : alertSuccess]" role="alert">
                {{this.message}}
            </div>
        </div>

        <!-- 生成ボタン -->
        <div class="row justify-content-center">
            <button type="submit" :disabled="!isActive" class=" btn btn-primary rounded-pill ml-3 mb-5 ">この局面を生成する</button>
        </div>
    </form>
</template>

<script>
export default {
    props:  {
      csrf: {
        type: String,
        required: true,
      }
    },
    data () {
        return {
            pai_text: '',
            pais: [],
            tumo: '',
            dora: '',
            message: '',
            hasError: false,
            isActive: false,
            alertWarning: 'alert-warning',
            alertSuccess: 'alert-success',
        }
    },
    mounted() {

        //
        //　マウント時にランダムな牌姿を生成しテキストにセットする
        //
        const shuffle = ([...array]) => {
             for (let i = array.length - 1; i >= 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
             }
            return array;
        }

        //牌昇順にソート用
        const orderByPaiAsc = (a,b) => {
            let tmp_a = a
            let tmp_b = b
            if(tmp_a.length === 2){
                tmp_a = tmp_a.substring(1,2)
            }
            if(tmp_b.length === 2){
                tmp_b = tmp_b.substring(1,2)
            }
            if(tmp_a !== tmp_b) {                                                
                if(tmp_a < tmp_b) return -1
                if(tmp_a > tmp_b) return  1 
            }
            if(a < b) return -1
            if(a > b) return  1 

            return 0
        }

        //全ての牌を生成
        let pais = ['1m','2m','3m','4m','5m','6m','7m','8m','9m',
                    '1s','2s','3s','4s','5s','6s','7s','8s','9s',
                    '1p','2p','3p','4p','5p','6p','7p','8p','9p',
                    '東','南','西','北','白','發','中']  
        let alls = []
        alls = alls.concat(pais).concat(pais).concat(pais).concat(pais)

        //並び替え
        alls = shuffle(alls)

        //ドラを取り出す
        let dora = alls[0]

        //再度並び替え
        alls = shuffle(alls)

        //ツモを取り出す
        let tumo = alls[13]

        //13牌取り出しつつ牌記号昇順にソートする
        let haipais = alls.slice(0,13).sort(orderByPaiAsc)

        //重複除外
        for(let i = 0; i < haipais.length - 1; ++i){
            if(haipais[i].length === 1) continue
            if(haipais[i].substring(1,2) === haipais[i + 1].substring(1,2)){
                haipais[i] = haipais[i].substring(0,1)
            } 
        }

        //テキストに展開しつつツモとドラを付与
        this.pai_text = haipais.join('') + 'ツモ' + tumo + 'ドラ' + dora

        //inputイベントを発火させる
        let e = new Event('input');
        let target = document.getElementById('input-pais');
        target.value = this.pai_text;
        target.dispatchEvent(e);

    },
    methods: {

        //テキスト入力イベント
        onPaiInput: function (event){

            this.pai_text = event.target.value
            this.pais = []
            this.tumo = ''
            this.dora = ''

            let text = this.pai_text

            //判定用に１バイトにしておく
            text = text.replace('ツモ','T')
            text = text.replace('ドラ','D')

            //テキストの逆から参照し表示用配列を生成する
            let msp = ''
            let no = 0
            for(let i = text.length - 1; i >= 0; --i){
                if( /m|s|p/.test(text[i])){

                    //数牌の単位が来たら保存
                    msp = text[i]
                }else if( /1|2|3|4|5|6|7|8|9/.test(text[i])){

                    //数牌の数字が来たら単位と共にプッシュ
                    if(msp !== ''){
                        let pai = {no:++no,img_path:'img/' + text[i] + msp + '.gif'}
                        this.pais.push(pai)
                    }

                }else if( /東|南|西|北|白|發|中/.test(text[i])){

                    //字牌はそのままプッシュ
                    let pai = {no:++no,img_path:'img/' + text[i] + '.gif'}
                    this.pais.push(pai)     
                }else if( /T/.test(text[i])){
                    //ツモが来たら直近の牌を変数に移動
                    if(this.pais.length > 0){
                        this.tumo = this.pais.pop().img_path
                    }
                }else if( /D/.test(text[i])){
                    //ドラが来たら直近の牌を変数に移動
                    if(this.pais.length > 0){
                        this.dora = this.pais.pop().img_path
                    }
                }else{
                    //それ以外の文字はスルー
                }
            }

            //完成後に反転
            this.pais.reverse()

            //エラー判定
            let tumo_cnt = 0
            if(this.tumo !== '') tumo_cnt = 1
            let cnt_jpn = '（' + (this.pais.length + tumo_cnt) + '牌'
            if(this.dora !== ''){
                cnt_jpn += '＋ドラ'
            }
            cnt_jpn += '）'

            if(this.pais.length + tumo_cnt === 14){
                this.hasError = false
                this.message  = '✓OK ' + cnt_jpn
                this.isActive = true

            }else{
                this.hasError = true
                this.message  = '×NG ' + cnt_jpn
                this.isActive = false
            }

            return;
        }
    }
}
</script>


