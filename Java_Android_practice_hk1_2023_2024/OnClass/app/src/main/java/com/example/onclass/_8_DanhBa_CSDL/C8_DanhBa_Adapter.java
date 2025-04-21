package com.example.onclass._8_DanhBa_CSDL;

import android.content.DialogInterface;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageButton;
import android.widget.PopupMenu;
import android.widget.TextView;

import androidx.appcompat.app.AlertDialog;

import com.example.onclass.R;

import java.util.List;

public class C8_DanhBa_Adapter extends BaseAdapter {
    private final List<C8_DanhBa> list;
    private final EditWithPopupMenu editWithPopupMenu;

    public C8_DanhBa_Adapter(List<C8_DanhBa> list, EditWithPopupMenu editWithPopupMenu) {
        this.list = list;
        this.editWithPopupMenu = editWithPopupMenu;
    }

    @Override
    public int getCount() {
        return list.size();
    }

    @Override
    public Object getItem(int i) {
        return list.get(i);
    }

    @Override
    public long getItemId(int i) {
        return i;
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if (view == null) {
            view = LayoutInflater.from(viewGroup.getContext()).inflate(R.layout.activity_c8_danh_ba_item, viewGroup, false);
        }

        TextView txtName = view.findViewById(R.id.txtName);
        TextView txtNumber = view.findViewById(R.id.txtNumber);
        ImageButton btnMenu = view.findViewById(R.id.btnMenu);

        txtName.setText(list.get(i).getName());
        txtNumber.setText(Integer.toString(list.get(i).getNumber()));

        btnMenu.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                PopupMenu popupMenu = new PopupMenu(view.getContext(), btnMenu);
                popupMenu.getMenuInflater().inflate(R.menu.c8_pop_up_danh_ba_menu_item, popupMenu.getMenu());
                popupMenu.setOnMenuItemClickListener(new PopupMenu.OnMenuItemClickListener() {
                    @Override
                    public boolean onMenuItemClick(MenuItem menuItem) {
                        if (menuItem.getItemId() == R.id.btnUpdate) {
                            editWithPopupMenu.editPerson(i);
                        }
                        if (menuItem.getItemId() == R.id.btnDelete) {
                            deleteConfirm(view, list.get(i), i);
                        }
                        return true;
                    }
                });
                popupMenu.show();
            }
        });
        return view;
    }

    private void deleteConfirm(View view, C8_DanhBa c8DanhBa, int i) {
        int vitri = i;
        AlertDialog.Builder builder = new AlertDialog.Builder(view.getContext()).setTitle("Xóa ?").setMessage("Bạn có muốn xóa ").setPositiveButton("Có", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialogInterface, int i) {
                editWithPopupMenu.DeleteDatabase(vitri);
                list.remove(vitri);
                notifyDataSetChanged();
            }
        }).setNegativeButton("Không", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialogInterface, int i) {
                dialogInterface.dismiss();
            }
        });

        AlertDialog alertDialog = builder.create();
        alertDialog.show();
    }
}
