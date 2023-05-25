
<template>

    <div>
        <form @submit.prevent="checkDomains">

            <textarea v-model="domainList" placeholder="Введите список доменов"></textarea>
            <br>
            <button type="submit">Проверить</button>
        </form>

        <table>
            <thead>
            <tr>
                <th>Домен</th>
                <th>Дата окончания</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="domain in domains" :key="domain.name">
                <td>{{ domain.name }}</td>
                <td>{{ domain.status}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>

export default {
    data() {
        return {
            domainList: '',
            domains: []
        };
    },
    methods: {
        async checkDomains() {

            const domainArray = this.domainList.split(/\s+/).filter(domain => domain.trim() !== '');


            try {
                const response = await axios.post('/domains/check', { domains: domainArray });
                this.domains = response.data;
            } catch (error) {
                console.error(error);
            }
        }
    }
};
</script>
