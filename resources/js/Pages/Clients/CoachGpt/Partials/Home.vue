<template>
    <div>
        <template v-if="answers.length > 0">
            <div class="american_company" id="american_company">
                <template v-for="(answer, index) in answers">
                    <div class="header_content" :id="'answer-'+index">
                        <img src="../../../../../../public/images/icons/profile.png" alt="">
                        <p style="line-height: 25px;">{{ answer.prompt }}</p>
                    </div>
                    <p class="ic-border"></p>
                    <div class="body_content">
                        <div style="gap:15px;" class="ic-icon-gpt-answer-wrap">
                            <template v-if="submitting && (answers.length -1 ) === index">
                                <!--                                            show image-->
                                <img style="width: 100%;" src="../../../../../../public/images/icons/loading.svg" alt="loading" class="ic-loading">
                            </template>
                            <template v-else>

                                <div class="icon">
                                    <img src="../../../../../../public/images/icons/home-red.png" alt="">
                                </div>
                                <div class="answer">
                                    <template v-for="(message, index) in answer.response" :key="index">
                                        <div v-if="message.type === 'text'" :class="[{'ic-error' : message.error}]">
                                            {{ message.content }} <span v-if="message?.error"><img src="../../../../../../public/images/icons/denied.png" alt=""></span>
                                        </div>


                                        <pre v-else-if="message.type === 'code'">
<code :class=" message.content.language">
<template v-for="(code, index) in message.content.code">{{ code }}<br/></template>
</code>
</pre>
                                        <ul v-else-if="message.type === 'list'">
                                            <li v-for="(item, i) in message.content" :key="i">{{ item }}</li>
                                        </ul>
                                        <table v-else-if="message.type === 'table'">
                                            <thead>
                                            <tr>
                                                <th v-for="header in message.content.headers" :key="header">{{ header }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="row in message.content.data" :key="row.join('_')">
                                                <td v-for="item in row" :key="item" v-html="item"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </template>
                                </div>
                            </template>
                        </div>
                        <div style="line-height: 29px;margin-left: 53px;">

                        </div>
                    </div>
                    <p class="ic-border"></p>
                </template>
            </div>
        </template>
        <template v-else>
            <div class="real_state_container">
                <div style="margin-bottom: 30px;" class="real_state_header">
                    <img style="margin-bottom: 10px;" src="../../../../../../public/images/icons/robot-big.png" alt="">
                    <h5 style="margin-bottom: 3px;">Real Estate</h5>
                    <h5>CoachGPT</h5>

                </div>
                <div class="real_state_cards" :style="submitting ? 'margin-bottom: 45px;' : 'margin-bottom: 150px;'">
                    <div class="real_state_card">
                        <div class="card_header">
                            <img src="../../../../../../public/images/icons/building.svg" alt="">
                            <h6>Real Estate Genius</h6>
                        </div>
                        <p>Our A.I. Model Is Fine-Tuned With The Most Advanced Real Estate Investing, Wholesaling,
                            And Flipping Training</p>
                    </div>
                    <div class="real_state_card">
                        <div class="card_header">
                            <img src="../../../../../../public/images/icons/eos-icons_ai.png" alt="">
                            <h6>Personalized A.I. Coaching</h6>
                        </div>
                        <p>Ask Any Question Below And Your Very Own A.I. Real Estate Coach Will Give You The Perfect
                            Personalized Answers</p>
                    </div>
                    <div class="real_state_card">
                        <div class="card_header">
                            <img src="../../../../../../public/images/icons/bx_support.png" alt="">
                            <h6>DealHunter Support</h6>
                        </div>
                        <p>Get Support For Questions About Our DealHunter Software Without Having To Wait For
                            Support Rep</p>
                    </div>
                </div>
            </div>
        </template>
        <div  class="ans_send" :class="[{'p-disabled': submitting}]">
            <input type="text" placeholder="Type Question..." v-on:keyup.enter="getAnswer" ref="prompt" v-model="prompt">
            <img v-if="!submitting" src="../../../../../../public/images/icons/bi_send-fill.png" :aria-disabled="prompt.length < 0" alt="send icon" @click="getAnswer">
            <img v-else src="../../../../../../public/images/icons/loading.svg" class="ic-submit-loading">
        </div>
    </div>
</template>

<script>
export default {
    name: "RealStateHome",
    props: {
        user : Object,
    },
    data() {
        return {
            prompt: '',
            prompt_error: false,
            submitting: false,
            answers: [],
        }
    },
    methods: {
        scrollToElement(el) {
            const element = document.getElementById(el);

            if (element) {
                const offset = 80;
                const position = element.offsetTop - offset;
                window.scrollTo(0, position);
                // element.scrollIntoView({
                //
                //     behavior: 'smooth'
                // });
            }
        },
        delay(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        },
        async getAnswer() {
            if (this.user.total_credits <= 1){
                this.$toast.add({
                    severity: "error",
                    summary: "Error",
                    detail: 'Please top up your credits before you can ask questions.',
                    life: 3000,
                });
                return;
            }
            if (this.prompt === '') {
                this.prompt_error = true;
                return;
            } else {
                this.prompt_error = false;
            }
            this.submitting = true;

            // remove focus from the input
            this.$refs.prompt.blur();


            // push the prompt to the answers array
            let index = this.answers.length;

            //add a focus icon to the response
            this.answers.push({
                prompt: this.prompt,
                response: [{ type: 'text', content: '' }]
            });

            this.$emit('setHasAnswers', true);

            // now scroll to the bottom
            this.$nextTick(() => {
                this.scrollToElement(`answer-${index}`);
            })

            const response = await axios.post('/coach-gpt/get-answer', {
                prompt: this.prompt,
            });

            this.handleResponse(response.data);
            this.submitting = false;
            if (response.data.status === 'success') {
                this.$emit('updateBalance', response.data.available_credit);

                const messages = [];
                const lines = response.data.prompt_answer.response.split('\n');
                for (let i = 0; i < lines.length; i++) {
                    let line = lines[i];
                    if (typeof line === 'string' && line.trim().startsWith('|')) {
                        const headers = line
                            .substring(1, line.length - 1)
                            .split('|')
                            .map(header => header.trim());
                        i++;
                        let separator = lines[i].trim();
                        const data = [];
                        i++;
                        while (typeof lines[i] === 'string' && lines[i].trim().startsWith('|')) {
                            data.push(
                                lines[i]
                                    .substring(1, lines[i].length - 1)
                                    .split('|')
                                    .map(item => item.trim())
                            );
                            i++;
                        }
                        messages.push({ type: 'table', content: { headers, data } });
                        i--;
                    } else if (typeof line === 'string' && line.startsWith('```')) {
                        const lang = line.substring(3);
                        const language = 'language-'+lang;
                        i++;
                        const code = [];
                        while (typeof lines[i] === 'string' && !lines[i].startsWith('```')) {
                            code.push(lines[i]);
                            i++;
                        }
                        messages.push({ type: 'code', content: { language, code } });

                    } else if (typeof line === 'string' && line.startsWith('* ')) {
                        const items = [];
                        while (typeof lines[i] === 'string' && lines[i].startsWith('* ')) {
                            items.push(lines[i].substring(2));
                            i++;
                        }
                        messages.push({ type: 'list', content: items });
                        i--;
                    } else {
                        messages.push({ type: 'text', content: line });
                    }
                }
                this.answers[index].response = messages;
                // now scroll to the bottom
                this.$nextTick(() => {
                    this.scrollToElement(`answer-${index}`);
                })
                this.prompt = '';
            } else {
                this.answers[index].response = [{ type: 'text', content: 'Sorry, something went wrong please try again.', error: true }];
            }
        },

        handleResponse(response) {
            console.log(response.status)
            switch (response.status) {
                case "error":
                    this.$toast.add({
                        severity: "error",
                        summary: "Error",
                        detail: response.message,
                        life: 3000,
                    });
                    break;
            }
        },
    }
}
</script>
<style type="text/css" scoped>
.ic-section {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ccc;
    cursor: pointer;
    transition: .2s linear;
}
.loader {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: inline-block;
    position: relative;
    border: 3px solid;
    border-color: #FFF #FFF transparent transparent;
    box-sizing: border-box;
    animation: rotation 1s linear infinite;
}
.loader::after,
.loader::before {
    content: '';
    box-sizing: border-box;
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    margin: auto;
    border: 3px solid;
    border-color: transparent transparent #FF3D00 #FF3D00;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    box-sizing: border-box;
    animation: rotationBack 0.5s linear infinite;
    transform-origin: center center;
}
.loader::before {
    width: 32px;
    height: 32px;
    border-color: #FFF #FFF transparent transparent;
    animation: rotation 1.5s linear infinite;
}

@keyframes rotation {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
@keyframes rotationBack {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(-360deg);
    }
}

.american_company .answer div:not(:last-child) {
    margin-bottom: 20px;
}
.american_company table {
    margin-bottom: 20px;
}

.american_company td, .american_company th {
    border: 1px solid #ddd;
    padding: 8px;
}


.american_company tr:nth-child(even){background-color: #f2f2f2;}

.american_company tr:hover {background-color: #ddd;}

.american_company th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #ecebeb;
}

pre{
    background: #f0f0f0;
    padding: 0px 20px;
    border-radius: 6px;
    color: #fff;
    margin: 20px 0px;
}
code[class*="language-"], pre[class*="language-"] {
    text-shadow: none;
    color: #101136;
}
.ic-loading{
    height: 100px;
}
.ic-submit-loading{
    height: 21px;

}
.p-disabled, .p-component:disabled {
    opacity: 0.80 !important;
}
.ic-error{
    color: #db0f19;
}
.american_company {
    scroll-margin-top: 100px;
}
.layout-wrapper.layout-static .layout-main-container {
    margin-left: 0px !important;
}
.layout-main-container {
    padding: 7rem 0 2rem 4rem;
}
@media (min-width: 992px){
    .layout-wrapper.layout-static .layout-main-container {
        margin-left: 0px;
    }
}
</style>
