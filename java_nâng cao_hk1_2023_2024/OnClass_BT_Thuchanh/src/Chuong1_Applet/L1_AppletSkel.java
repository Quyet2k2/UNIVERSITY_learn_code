package Chuong1_Applet;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

import java.applet.Applet;
import java.awt.Graphics;

/**
 *
 * @author admin0512
 */
public class L1_AppletSkel extends Applet {

	/**
	 * Initialization method that will be called after the L1_AppletSkel is loaded
	 * into the browser.
	 */
	public void init() {
		// TODO start asynchronous download of heavy resources
		System.out.println("Applet init");
	}

	public void start() {
		// TODO start asynchronous download of heavy resources
		System.out.println("Applet Start");
	}

	public void paint(Graphics g) {
		// TODO start asynchronous download of heavy resources
		g.drawString("Xin chao", 50, 25);
		System.out.println("Applet Paint");
	}

	public void stop() {
		// TODO start asynchronous download of heavy resources
		System.out.println("Applet Stop");
	}

	public void destroy() {
		// TODO start asynchronous download of heavy resources
		System.out.println("Applet Destroy");
	}

	// TODO overwrite start(), stop() and destroy() methods
}
