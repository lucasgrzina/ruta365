<div class="table-responsive">
    <table class="table m-b-0" id="contactos-table">
        <thead>
            <tr>
                <th @click="orderBy('id')" class="td-id" :class="cssOrderBy('id')">ID</th>
                <th>Registrado</th>
                <th>Sucursal / Retail</th>
                <th>Mensaje</th>
                <th class="td-enabled">Leido</th>
                <th class="td-actions">{{ trans('admin.table.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in list" v-if="paging.total > 0">
                <td>(% item.id %)</td>
                <td>(% item.registrado.nombre.concat(' ' + item.registrado.apellido) %)</td>
                <td>(% item.registrado.sucursal.nombre + ' / ' + item.registrado.sucursal.retail.nombre %)</td>
                <td>(% item.mensaje %)</td>
                <td class="td-enabled">
                    @if(auth()->user()->hasRole('Superadmin') || auth()->user()->can('editar-'.$data['action_perms']))
                        <switch-button v-model="item.leido" theme="bootstrap" type-bold="true" @onChange="onChangeEnabled(item)"></switch-button>
                    @else
                        <span class="label" :class="{'label-success':item.leido,'label-error':!item.leido,}">
                            (% item.leido ? 'SI' : 'NO' %)
                        </span>
                    @endif
                </td>  
                <td class="td-actions">
                    @if(auth()->user()->hasRole('Superadmin') || auth()->user()->can('ver-'.$data['action_perms']))
                        <button-type type="show-list" @click="show(item)"></button-type>
                    @endif
                    @if(auth()->user()->hasRole('Superadmin') || auth()->user()->can('editar-'.$data['action_perms']))
                        <button-type type="edit-list" @click="edit(item)"></button-type>
                        <button-type type="remove-list" @click="destroy(item)"></button-type>
                    @endif
                </td>            
            </tr>
        </tbody>
    </table>
</div>