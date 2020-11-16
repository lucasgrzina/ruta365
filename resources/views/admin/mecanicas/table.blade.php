<div class="table-responsive">
    <table class="table m-b-0" id="mecanicas-table">
        <thead>
            <tr>
                <th @click="orderBy('id')" class="td-id" :class="cssOrderBy('id')">ID</th>
                <th>Cuerpo</th>
                <th>Retail</th>
                <th class="td-enabled">{{ trans('admin.table.enabled') }}</th>
                <th class="td-actions">{{ trans('admin.table.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in list" v-if="paging.total > 0">
                <td>(% item.id %)</td>
                <td>(% item.cuerpo %)</td>
                <td>(% item.retail.nombre %) ((% item.retail.pais.nombre %))</td>
                <td class="td-enabled">
                    @if(auth()->user()->hasRole('Superadmin') || auth()->user()->can('editar-'.$data['action_perms']))
                        <switch-button v-model="item.enabled" theme="bootstrap" type-bold="true" @onChange="onChangeEnabled(item)"></switch-button>
                    @else
                        <span class="label" :class="{'label-success':item.enabled,'label-error':!item.enabled,}">
                            (% item.enabled ? 'SI' : 'NO' %)
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