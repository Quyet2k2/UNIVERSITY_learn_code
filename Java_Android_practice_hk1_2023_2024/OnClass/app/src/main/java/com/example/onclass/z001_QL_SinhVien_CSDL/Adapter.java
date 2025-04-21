package com.example.onclass.z001_QL_SinhVien_CSDL;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import com.example.onclass.R;

import java.util.List;

public class Adapter extends BaseAdapter {
    private final List<Person> list;

    public Adapter(List<Person> list) {
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
        return list.get(i).getId();
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if (view == null) {
            view = LayoutInflater.from(viewGroup.getContext()).inflate(R.layout.activity_z001_list_view_item, viewGroup, false);
        }

        TextView tvName = view.findViewById(R.id.tvName);
        tvName.setText(list.get(i).getName());
        TextView tvNgaySinh = view.findViewById(R.id.tvNgaySinh);
        tvNgaySinh.setText(list.get(i).getNgaySinh());

        return view;
    }
}
