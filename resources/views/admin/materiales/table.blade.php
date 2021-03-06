<div class="table-responsive">
    <table class="table m-b-0" id="materiales-table">
        <thead>
            <tr>
                <th @click="orderBy('id')" class="td-id" :class="cssOrderBy('id')">ID</th>
                <th>Fecha</th>
                <th>Sucursal</th>
                <th>Retail</th>
                <th>Pais</th>
                <th>Tipo</th>
                <th>Archivo</th>
                <th>Descripcion</th>
                <th class="td-actions">{{ trans('admin.table.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in list" v-if="paging.total > 0">
                <td>(% item.id %)</td>
                <td>(% item.created_at | dateFormat %)</td>
                <td>(% item.sucursal.nombre %)</td>
                <td>(% item.sucursal.retail.nombre %)</td>
                <td>(% item.sucursal.retail.pais.nombre %)</td>
    
                <td>(% mostrarTipo(item.tipo) %)</td>
                <td>
                    <a :href="item.imagen_url" target="_blank">
                        Descargar / Abrir
                    </a>
                </td>
                <td>(% item.descripcion %)</td>
                <td class="td-actions">
                    @if(auth()->user()->hasRole('Superadmin') || auth()->user()->can('ver-'.$data['action_perms']))
                        <button-type type="show-list" @click="show(item)"></button-type>
                    @endif
                    @if(auth()->user()->hasRole('Superadmin') || auth()->user()->can('editar-'.$data['action_perms']))
                        <button-type v-if="item.tipo != 'R'" type="edit-list" @click="edit(item)"></button-type>
                        <button-type type="remove-list" @click="destroy(item)"></button-type>
                    @endif
                </td>            
            </tr>
        </tbody>
    </table>
</div>