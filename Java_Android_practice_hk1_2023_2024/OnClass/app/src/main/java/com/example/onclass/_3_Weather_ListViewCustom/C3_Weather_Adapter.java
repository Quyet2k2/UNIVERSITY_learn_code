package com.example.onclass._3_Weather_ListViewCustom;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.example.onclass.R;

import java.util.ArrayList;

public class C3_Weather_Adapter extends BaseAdapter {
    private final Context context;
    private final ArrayList<C3_Weather> list;

    public C3_Weather_Adapter(Context context, ArrayList<C3_Weather> list) {
        this.context = context;
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
            view = LayoutInflater.from(viewGroup.getContext()).inflate(R.layout.activity_3_item_thoitiet, viewGroup, false);
        }
        TextView textView1 = view.findViewById(R.id.txtName);
        textView1.setText(list.get(i).getAddress());
        TextView textView2 = view.findViewById(R.id.txtC);
        textView2.setText(String.valueOf(list.get(i).getC()));
        TextView textView3 = view.findViewById(R.id.txtState);
        textView3.setText(list.get(i).getWeather());
        ImageView imageView = view.findViewById(R.id.imgThoiTiet);
        imageView.setImageResource(list.get(i).getImage());
        return view;
    }

}
