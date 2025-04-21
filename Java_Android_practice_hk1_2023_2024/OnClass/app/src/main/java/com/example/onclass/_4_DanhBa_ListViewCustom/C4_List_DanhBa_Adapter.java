package com.example.onclass._4_DanhBa_ListViewCustom;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.example.onclass.R;

import java.util.List;

public class C4_List_DanhBa_Adapter extends BaseAdapter {
    private final Context context;
    private final int layout;
    private final List<C4_DanhBa> list;

    public C4_List_DanhBa_Adapter(Context context, int layout, List<C4_DanhBa> list) {
        this.context = context;
        this.layout = layout;
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
        LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        view = inflater.inflate(layout, null);

        TextView txtName = view.findViewById(R.id.txtName);
        TextView txtNumber = view.findViewById(R.id.txtNumber);
        ImageView imgContact = view.findViewById(R.id.imgContact);
        ImageView imgDelete = view.findViewById(R.id.imgDelete);

        C4_DanhBa c4DanhBa = list.get(i);
        txtName.setText(c4DanhBa.getTxtName());
        txtNumber.setText(c4DanhBa.getTxtNumber());
        imgContact.setImageResource(c4DanhBa.getImgContact());
        imgDelete.setImageResource(c4DanhBa.getImgDelete());

        imgDelete.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                list.remove(i);
                notifyDataSetChanged();
            }
        });
        return view;
    }
}
