<div class="table-responsive">
    <table class="table m-b-0" id="registrados-table">
        <thead>
            <tr>
                <th @click="orderBy('id')" class="td-id" :class="cssOrderBy('id')">ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Sucursal</th>
                <th>Retail</th>
                <th>Pais</th>
                <th class="td-enabled td-actions">Confirmado</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in list" v-if="paging.total > 0">
                <td>(% item.id %)</td>
                <td>(% item.nombre %)</td>
                <td>(% item.apellido %)</td>
                <td>(% item.email %)</td>
                <td>(% item.sucursal.nombre %)</td>
                <td>(% item.sucursal.retail.nombre %)</td>
                <td>(% item.sucursal.retail.pais.nombre %)</td>
                <td class="td-enabled td-actions">
                    <template v-if="item.confirmado == 2">
                        <button-type type="check-list" @click="enableRegistered(item,true)" :disabled="confirmando"></button-type>
                        <button-type type="close-list" @click="enableRegistered(item,false)" :disabled="confirmando"></button-type>
                    </template>
                    <switch-button v-else v-model="item.confirmado" theme="bootstrap" type-bold="true" @onChange="onChangeEnabled(item)"></switch-button>
                </td>                          
            </tr>
        </tbody>
    </table>
</div>