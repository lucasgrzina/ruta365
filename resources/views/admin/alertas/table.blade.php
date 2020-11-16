<div class="table-responsive">
    <table class="table m-b-0" id="alertas-table">
        <thead>
            <tr>
                <th @click="orderBy('id')" class="td-id" :class="cssOrderBy('id')">ID</th>
                <th>Fecha</th>
                <th>Registrado</th>
                <th>Sucursal</th>
                <th>Retail</th>
                <th>Pais</th>
                <th>Descripcion</th>
                <th>Leido</th>
                <th>Observaciones</th>
                <th class="td-actions">{{ trans('admin.table.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in list" v-if="paging.total > 0">
            <td>(% item.id %)</td>
            <td>(% item.created_at | datetimeFormat %)</td>
            <td>(% item.usuario.nombre + ' ' + item.usuario.apellido %)</td>
            <td>(% item.sucursal.nombre %)</td>
            <td>(% item.sucursal.retail.nombre %)</td>
            <td>(% item.sucursal.retail.pais.nombre %)</td>
            <td>(% item.descripcion %)</td>
            <td>
                <span v-if="owner" :class="{'label': true, 'label-success': item.leido,'label-danger': !item.leido}">
                    (% item.leido ? 'SI' : 'NO' %)
                </span>
                <switch-button v-else v-model="item.leido" theme="bootstrap" type-bold="true" @onChange="onChangeEnabled(item)"></switch-button>                            
            </td>
            <td>(% item.observaciones %)</td>
                <td class="td-actions">
                    @if(auth()->user()->hasRole('Superadmin') || auth()->user()->can('editar-'.$data['action_perms']))
                        <button-type type="edit-list" @click="edit(item)"></button-type>
                        <button-type type="remove-list" @click="destroy(item)"></button-type>
                    @endif
                </td>            
            </tr>
        </tbody>
    </table>
</div>