package com.example.onclass._9_QL_NhanVien_CSDL;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.ImageView;
import android.widget.TextView;

import com.example.onclass.R;

import java.util.List;

public class C9_Adapter_NhanVien extends BaseAdapter {
    private final List<C9_NhanVien> list;

    public C9_Adapter_NhanVien(List<C9_NhanVien> list) {
        this.list = list;
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
            view = LayoutInflater.from(viewGroup.getContext()).inflate(R.layout.activity_c9_nhan_vien_item, viewGroup, false);
        }

        ImageView imageView = view.findViewById(R.id.imageView);
        if (list.get(i).getGioiTinh() == 1) {
            imageView.setImageResource(R.mipmap.ic_man_launcher);
        }
        if (list.get(i).getGioiTinh() == 0) {
            imageView.setImageResource(R.mipmap.ic_woman_launcher);
        }

        TextView txtName = view.findViewById(R.id.txtName);
        txtName.setText(list.get(i).getName());

        CheckBox checkBox = view.findViewById(R.id.checkbox);
        checkBox.setChecked(list.get(i).getCheck() == 1);
        checkBox.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
            @Override
            public void onCheckedChanged(CompoundButton compoundButton, boolean b) {
                int check = (b) ? 1 : 0;
                list.get(i).setCheck(check);
                String sql = "update info set isCheck = " + "'" + check + "'" + " where id = " + "'" + list.get(i).getId() + "'";
                C9_QL_NhanVien_CSDL.getDatabase().execSQL(sql);
            }
        });

        return view;
    }
}
