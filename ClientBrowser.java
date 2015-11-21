import java.net.*;
import java.io.*;
/*
* Created by acciaro emilio
*/
public class ClientBrowser {
	public void start()throws IOException {
		BufferedReader stdIn = new BufferedReader(new InputStreamReader(System.in));
		// informazioni richiesta http
		System.out.print("Inserire l'URL nel formato 'www.nomesito.dominio': ");
		String url = stdIn.readLine();
		System.out.print("Inserire il metodo: ");
		String method = stdIn.readLine();
		System.out.print("Inserire il path-resource: ");
		String resource = stdIn.readLine();

		Socket socket = new Socket(url, 80);
		//Stream di byte da passare al Socket
		DataOutputStream os = new DataOutputStream(socket.getOutputStream());
		DataInputStream is = new DataInputStream(socket.getInputStream());
		
		String packet = method+" "+resource+" HTTP/1.1\r\nAccept:\r\nAccept-Language: en-us\r\nUser-agent:Prova/1.0\r\nHost: "+url+"\r\n";
		int count = 0;
		do{
			os.writeBytes(packet + '\n');
			System.out.println("" + is.readLine());
			count++;
			packet = "";
		}while (count<10);
		os.close();
		is.close();
		socket.close();
    }
	public static void main (String[] args) throws Exception {
		ClientBrowser tcpClient = new ClientBrowser();
		tcpClient.start();
	}
}
